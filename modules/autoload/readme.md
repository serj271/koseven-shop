## Kohana Autoloder Modul


With the Kohana Autoloader Modul is it possible to use Namespaces in Classes.

Example Call:
	
	$classLoader = new ClassLoader('Namespace\For\Class', PATH_TO_CLASSES);
	$classLoader->register();

With this setting, it is possible to load the Class 
	
	new \Namespace\For\Class\Test();
	
with just the shortcut
	
	new Test();


## Notice

Dont Place functions in locations where the default autoloader would find the file.

If you have the class **\Namespace\For\Class\Test()** located in the directory **application/classes/test.php**
then it is not possible to use the function **Test()** because the kohana autoloader loads the file but because of the namespace the class **Test()** does not exists.