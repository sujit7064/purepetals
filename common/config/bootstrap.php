<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@storage', dirname(dirname(__DIR__)) . '/storage');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');

$web_protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';
$project_folder_name = '/';
Yii::setAlias('@project_folder_name', $project_folder_name);

Yii::setAlias('@frontendUrl', $web_protocol . "://" . $_SERVER['SERVER_NAME'] . $project_folder_name . "");
Yii::setAlias('@backendUrl', $web_protocol . "://" . $_SERVER['SERVER_NAME'] . $project_folder_name . "/backend");
Yii::setAlias('@storageUrl', $web_protocol . "://" . $_SERVER['SERVER_NAME'] . $project_folder_name . "/storage");
Yii::setAlias('@apiUrl', $web_protocol . "//" . $_SERVER['SERVER_NAME'] . $project_folder_name . "/api");
