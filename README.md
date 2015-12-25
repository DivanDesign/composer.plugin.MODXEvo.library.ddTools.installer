# ddTools installer

A composer plugin allowing installation of ddTools maintaining compatibility with the old versions of the library.

## Changelog

### Version 1.0.5 (2015-12-25)
* \* Installer → overrideOldVersionFile: The method now replaces the old version file content anyway.
* \* The replacing content now contains an autoload.php require instead of the ddTools class file directly.

### Version 1.0.4 (2015-11-09)
* \+ A missing check for an old version backup has been added inside the “overrideOldVersionFile” method.
* \* Changed the contents for an old version file.

### Version 1.0.3 (2015-10-15)
* \* Fixed an error within the ddTools relative path.

### Version 1.0.2 (2015-10-15)
* \* Absolute path for including ddTools was replaced with a relative one.

### Version 1.0.1 (2015-10-04)
* \* Package name fix.

### Version 1.0.0 (2015-10-04)
* \+ The first release.
___
Visit the following [link](http://code.divandesign.biz/modx/ddtools) to read the documentation, instructions & changelog.