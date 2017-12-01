<?php

$vendorDir = dirname(__DIR__);

return array (
  'yiisoft/yii2-bootstrap' => 
  array (
    'name' => 'yiisoft/yii2-bootstrap',
    'version' => '9999999-dev',
    'alias' => 
    array (
      '@yii/bootstrap' => $vendorDir . '/yiisoft/yii2-bootstrap',
    ),
  ),
  'yiisoft/yii2-swiftmailer' => 
  array (
    'name' => 'yiisoft/yii2-swiftmailer',
    'version' => '2.0.7.0',
    'alias' => 
    array (
      '@yii/swiftmailer' => $vendorDir . '/yiisoft/yii2-swiftmailer',
    ),
  ),
  'yiisoft/yii2-debug' => 
  array (
    'name' => 'yiisoft/yii2-debug',
    'version' => '9999999-dev',
    'alias' => 
    array (
      '@yii/debug' => $vendorDir . '/yiisoft/yii2-debug',
    ),
  ),
  'yiisoft/yii2-gii' => 
  array (
    'name' => 'yiisoft/yii2-gii',
    'version' => '9999999-dev',
    'alias' => 
    array (
      '@yii/gii' => $vendorDir . '/yiisoft/yii2-gii',
    ),
  ),
  'yiisoft/yii2-faker' => 
  array (
    'name' => 'yiisoft/yii2-faker',
    'version' => '9999999-dev',
    'alias' => 
    array (
      '@yii/faker' => $vendorDir . '/yiisoft/yii2-faker',
    ),
  ),
  'funson86/yii2-auth' =>
  array (
    'name' => 'funson86/yii2-auth',
    'version' => '9999999-dev',
    'alias' =>
    array(
      '@funson86/auth' => $vendorDir . '/funson86/yii2-auth',
    ),
    'bootstrap' => 'funson86\\auth\\Bootstrap',
  ),

  'funson86/yii2-cms' =>
  array (
    'name' => 'funson86/yii2-cms',
    'version' => '9999999-dev',
    'alias' =>
    array(
      '@funson86/cms' => $vendorDir . '/funson86/yii2-cms',
    ),
    'bootstrap' => 'funson86\\cms\\Bootstrap',
  ),

  'funson86/yii2-blog' => 
  array (
    'name' => 'funson86/yii2-blog',
    'version' => '9999999-dev',
    'alias' => 
    array (
      '@funson86/blog' => $vendorDir . '/funson86/yii2-blog',
    ),
    'bootstrap' => 'funson86\\blog\\Bootstrap',
  ),

  'mihaildev/yii2-ckeditor' =>
  array (
    'name' => 'mihaildev/yii2-ckeditor',
    'version' => '9999999-dev',
    'alias' => 
    array(
        '@mihaildev/ckeditor' => $vendorDir . '/mihaildev/yii2-ckeditor',
    ),
  ),

  'devgroup/yii2-dropzone' => 
  array (
    'name' => 'devgroup/yii2-dropzone',
    'version' => '9999999-dev',
    'alias' => 
    array (
      '@devgroup/dropzone' => $vendorDir . '/devgroup/yii2-dropzone',
    ),
  ),

  'yiisoft/yii2-imagine' => 
  array (
    'name' => 'yiisoft/yii2-imagine',
    'version' => '9999999-dev',
    'alias' => 
    array (
      '@yii/imagine' => $vendorDir . '/yiisoft/yii2-imagine',
    ),
  ),


);
