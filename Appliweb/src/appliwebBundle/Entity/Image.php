<?php

namespace appliwebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Image
{
  //attribut = notre image
  private $file;

// renvoie l'attribut file
public function getFile()
{
return $this->file;
}

//set l'attribut file
public function setFile($file)
{
$this->file = $file;
}



//upload l'image dans le bon dossier
  public function upload($chemin,$name)
  {
    // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
    if (null === $this->file) {
      return;
    }
    // On déplace le fichier envoyé dans le répertoire de notre choix (chemin)
    //et on le renomme avec la variable name
    $this->file->move($chemin, $name);

  }

}
?>
