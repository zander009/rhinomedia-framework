# rhinomedia-f

rhinomedia-f is a framework made in PHP 7. This framework is not as powerful as the existing framework like Laravel, Symphony, Codeigniter, etc. It is an opensource framework where you can change any of those codes. Feel free to upgrade it.

# Short History:

The author is just busy struggling in his day job located in the Philippines, when his boss assigned him to create a websites for big condominiums in Australia. But the author is tired enough to create the system from scratch and then he decided to create a framework. First, he named it `stick-o` for the reason that he saw a jar of stick-o laying around in his fellow workmates table then `stick-o` born. Soon enough his boss created a new firm named Rhino Media and then suddenly he renamed it to `rhinomedia-f`.

The Architecture of the framework was inspired by the framework created by his Indonesian friend named Irvan [@mr_vero](https://github.com/Mr-vero) (follow him on github and fork some of his work) the author of `framework-f`.


# Requirement:

 - PHP >= 7.0
 - PDO

# Installation:

Install via git:

 ```
 git clone https://github.com/zander009/rhinomedia-f.git
 ```

Install via clone or download:

``` 
download zip file then extract it to your localhost server folder
```

Install via Composer:

```
composer require rhinomedia/framework
```
 
# Create a new Database 

 - Open phpMyAdmin and create a new database name it `rhino_db`
 - Extract the database file located in your root folder and import it

# Edit .htaccess file

Open `.htaccess` file in your root folder and change `rhinomedia-f` words into your project name

# Edit Configurations

Open `config.ini` file by default it is in development mode. You can change it to production mode also. Beware of spaces and new lines it is case sensitive so check it first.

There are more few steps in configurations:

 - Go to `application > config > development.php ` 
 - You can now set your configurations.
 - Now you must change `rhinomedia-f` words into your project name

Now you can enjoy using the framework

```
Note: The framework doesn't have an error handler but you can create one
```
