<?php
namespace MODXEvoDDToolsInstaller;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Repository\InstalledRepositoryInterface;

class Installer extends LibraryInstaller {
	private $ddToolsClassFileName = "modx.ddtools.class.php",
			$ddToolsOldVersionBackupFileName = "modx.ddtools.class_old.php",
			$ddToolsPath = 'assets/libs/ddTools/',
			$ddToolsDeprecatedPath = "assets/snippets/ddTools/",
			$ddToolsPackageName = "dd/modxevo-library-ddtools",
			$ddToolsType = "modxevo-library-ddtools";
	
	public function getPackageBasePath(PackageInterface $package){
		if($package->getPrettyName() !== $this->ddToolsPackageName){
			throw new \InvalidArgumentException("The library being installed ({$package->getPrettyName()}) is not ddTools ({$this->ddToolsPackageName}). Installation aborted.");
		}
		
		return $this->ddToolsPath;
	}
	
	public function supports($packageType){
		return $this->ddToolsType === $packageType;
	}
	
	public function install(InstalledRepositoryInterface $repo, PackageInterface $package){
		parent::install($repo, $package);
		$this->overrideOldVersionFile();
	}
	
	public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target){
		parent::update($repo, $initial, $target);
		$this->overrideOldVersionFile();
	}
	
	public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package){
		$this->restoreOldVersionFile();
		parent::uninstall($repo, $package);
	}
	
	/**
	 * overrideOldVersionFile
	 * 
	 * Overrides an old version of ddTools if exists.
	 */
	private function overrideOldVersionFile(){
		$oldVersionFilePath = $this->ddToolsDeprecatedPath.$this->ddToolsClassFileName;
		$oldVersionBackupPath = $this->ddToolsDeprecatedPath.$this->ddToolsOldVersionBackupFileName;
		
		//Check if an old version of the library is in assets/snippets and its backup doesn't exist
		if(is_file($oldVersionFilePath) && !is_file($oldVersionBackupPath)){
			//Backup of the old version
			file_put_contents(
				$this->ddToolsDeprecatedPath.$this->ddToolsOldVersionBackupFileName,
				file_get_contents($oldVersionFilePath)
			);
			
			//Override the old version with a reference to the version being installed
			file_put_contents(
				$this->ddToolsDeprecatedPath.$this->ddToolsClassFileName,
				"<?php require_once(realpath(__DIR__.'/../../../".$this->ddToolsPath.$this->ddToolsClassFileName."')); ?>"
			);
		}
	}
	
	/**
	 * restoreOldVersionFile
	 * 
	 * Restores the old version of ddTools if existed.
	 */
	private function restoreOldVersionFile(){
		$oldVersionFilePath = $this->ddToolsDeprecatedPath.$this->ddToolsClassFileName;
		$oldVersionBackupFilePath = $this->ddToolsDeprecatedPath.$this->ddToolsOldVersionBackupFileName;
		
		//Check if an old version of the library is in assets/snippets and its backup exists 
		if(is_file($oldVersionBackupFilePath) && is_file($oldVersionFilePath)){
			//Restore from the backup
			file_put_contents(
				$this->ddToolsDeprecatedPath.$this->ddToolsClassFileName,
				file_get_contents($this->ddToolsDeprecatedPath.$this->ddToolsOldVersionBackupFileName)
			);
			
			//Remove backup
			unlink($oldVersionBackupFilePath);
		}
	}
}