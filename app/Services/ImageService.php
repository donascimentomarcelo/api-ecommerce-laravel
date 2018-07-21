<?php

namespace App\Services;
use Intervention\Image\ImageManagerStatic as Image;

class ImageService 
{
    /**
     * Esse método faz o resize da image para todos os tamanhos de modo que recebe 3 parametros
     * O request com o objeto com nome "FILE"
     * O largura e a altura.
     * O método fará o resize e retornará em memória a imagem.
     *
     * @param [file] $request
     * @return Image
     */
    public function resizeImage($request, $width, $height)
    {
        return Image::make($request->file('file')->getRealPath())->resize($width, $height)->stream();
    }
}