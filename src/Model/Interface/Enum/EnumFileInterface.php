<?php

namespace App\Model\Interface\Enum;

interface EnumFileInterface{

    public const typeDocs = [
        'docs' => ['docx', 'doc', 'txt', 'pdf','plain','vnd.openxmlformats-officedocument.wordprocessingml.document'],
        'object' => ['x-blender', 'obg','hdr','gltf-binary','octet-stream','zlib'],
        'calc' => ['xml', 'csv', 'vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
        'audio_video' => ['mp3', 'x-wav', 'ram', 'mpg', 'mp4','x-flv','x-m4a','ogg','webm','mpeg',],
        'image' => ['gif', 'jpg', 'jpeg', 'png', 'svg'],
        'code' => ['php', 'cpp', 'javascript', 'python', 'html', 'css','twig','ejs','ts'],
    ];
}

