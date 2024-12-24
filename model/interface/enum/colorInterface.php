<?php

namespace model\interface\enum;

interface colorInterface{
    public const Colour= 
    [
        "black",
        "red",
        "green",
        "yellow",
        "blue",
        "magenta",
        "cyan",
        "white",
    ];
    
    public const acceptableTextModif=
    [
        1=>'bold',
        3=>'italic',
        4=>'underline',
        9=>'strikethrough',
    ];
}