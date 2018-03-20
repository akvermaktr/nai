CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Configuration
 * Maintainers

INTRODUCTION
------------

Drupal 7 file validation is performed by file_validate_extensions 
which only relies on the file name extension. By using 'File Mime Type 
Checker', you can check the mime type of the file. 
'File Mime Type Checker' uses the php library 'fileinfo' and is dependent 
on that. Through this php lib we can perform a more secure and reliable 
check on the file's mime type and compare that to the allowed file extensions, 
as these are set by the admin within the content type's field settings. 

This module performs a server side validation for the extension 
of an uploaded file of any content type's file field as well as Image Field.
User can validate the file field & image field accrording to the condition
(Enable Mime Type Check in file or image field).

CONFIGURATION
-------------

After enabling this module, please check admin/config/media/mime_type.
Here you can set the default value for check mime type of the fields.

The module depends on the php library fileinfo. 
Please make sure this library is present and enabled on the server.

MAINTAINERS
-----------
Current maintainers:
 * Chetan Sharma- https://www.drupal.org/u/chetan-sharma
