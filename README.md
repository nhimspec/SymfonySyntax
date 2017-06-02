SymfonySyntax
=============

The "Symfony Syntax" is a reference application created to show how
to develop Symfony applications following the recommended best practices.


Requirements
------------

  * Symfony 2.7 or higher
  * Memcached Enabled.
  * PHP 5.5.9 or higher
  * PDO-SQLite PHP extension enabled, MySQL...
  * and the [usual Symfony application requirements](https://symfony.com/doc/2.8/reference/requirements.html).

If unsure about meeting these requirements, download the demo application and
browse the [http://localhost:8000/config.php](http://localhost:8000/config.php) script to get more detailed
information.


Bundles Added
------------
1. [FOSUser](http://symfony.com/doc/master/bundles/FOSUserBundle/index.html) v2.0 make it quick and easy to store users in a database. 
2. [HWIOAuth](https://github.com/hwi/HWIOAuthBundle) Social Login.
3. [VichUploader](https://github.com/dustin10/VichUploaderBundle) Upload and Store File.
4. [Pagerfanta](https://github.com/whiteoctober/WhiteOctoberPagerfantaBundle) Create Page Number.
5. [IvoryCKEditor](http://symfony.com/doc/current/bundles/IvoryCKEditorBundle/index.html) v4.0 Ckeditor Create/Edit Post.
6. [Aequasi Memcached](https://github.com/aequasi/cache-bundle) Save data to Memcached OR
[PHP-Cache](http://www.php-cache.com/) This is better.


Installation
------------

Install the [Symfony Installer](https://github.com/symfony/symfony-installer)
if you haven't already. Then, install the SymfonySyntax Application executing

```bash
    $ git clone https://github.com/nhimspec/SymfonySyntax SymfonySyntax
    $ cd SymfonySyntax/
    $ composer install
```

