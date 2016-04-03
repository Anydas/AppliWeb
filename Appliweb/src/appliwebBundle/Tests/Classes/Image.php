<?php

namespace appliwebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Image
{
  private $file;

public function getFile()
{
return $this->file;
}

public function setFile($file)
{
$this->file = $file;
}




  public function upload($chemin,$name)
  {
    // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
    if (null === $this->file) {
      return;
    }

    // On récupère le nom original du fichier de l'internaute


    // On déplace le fichier envoyé dans le répertoire de notre choix
    $this->file->move($chemin, $name);


  }

}
?>
