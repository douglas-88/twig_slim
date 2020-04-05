<?php


namespace Core;
use Intervention\Image\ImageManager;

class Image
{
    protected $intervention;

    protected $resizeWidth;

    protected $resizeHeight;

    protected $image;

    protected $rename;

    protected $resized = false;

    protected $type;

    protected $path = "assets/images/uploads/";

    public function __construct($imageNameInput)
    {
        mkdir("assets/images/uploads/",0777);
        $this->intervention = new ImageManager();

        $this->image = $_FILES[$imageNameInput];
    }

    private function rename(){

        $extension = pathinfo($this->image["name"],PATHINFO_EXTENSION);

        $this->rename = md5(uniqid()).date("_dmY-His").".{$extension}";

    }

    public function getName(){
        return $this->rename;
    }


    public function size($type){
        $size = $this->type($type);

        $target = getimagesize($this->image["tmp_name"]);

        $percent = ($target[0] > $target[1]) ? ($size / $target[0]) : ($size / $target[1]);

        //Novas Largura e Altura de forma proporcinal:
        $this->resizeWidth = round($target[0] * $percent);
        $this->resizeHeight = round($target[1] * $percent);

        $this->resized = true;
        $this->type = $type;

        return $this;
    }

    private function type($type){
        switch ($type){
            case "avatar":
                $size = 90;
            break;
            default:
                $size = 640;
            break;
        }

        return $size;
    }

    private function doUpload(){
        if(!$this->resized){
            throw new \Exception("Esta faltando você chamar o método size() para redimensionar essa foto");
        }

        $image = $this->intervention->make($this->image["tmp_name"])->resize($this->resizeWidth,$this->resizeHeight,function($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        if($this->type == "avatar"){
            $background = $this->intervention->canvas(90,90);
            $background->insert($image,"center");
            $background->save($this->path.$this->getName());
            return $this->path.$this->getName();
        }else{
            $image->save($this->path.$this->getName());
            return $this->path.$this->getName();
        }
    }

    public function delete($photo){
        @unlink($photo);
    }

    public function upload(){

        $this->rename();
        return $this->doUpload();
    }
}