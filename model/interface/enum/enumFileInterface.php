<?php

namespace model\interface\enum;

interface enumFileInterface{

    public const typeDocs = [
        'docs' => ['docx', 'doc', 'txt', 'pdf'],
        'object' => ['blend', 'obg','hdr','glb','octet-stream'],
        'calc' => ['xml', 'csv', 'xslx'],
        'audio_video' => ['mp3', 'wav', 'ram', 'mpg', 'mp4'],
        'image' => ['gif', 'jpg', 'jpeg', 'png', 'svg'],
        'code' => ['php', 'cpp', 'js', 'py', 'html', 'css','twig','ejs','ts'],
    ];
}
