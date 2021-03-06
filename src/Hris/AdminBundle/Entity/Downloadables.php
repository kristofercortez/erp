<?php

namespace Hris\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gist\CoreBundle\Template\Entity\HasGeneratedID;
use Gist\CoreBundle\Template\Entity\HasName;
use Gist\CoreBundle\Template\Entity\HasNotes;
use Gist\CoreBundle\Template\Entity\TrackCreate;
use Gist\MediaBundle\Template\Entity\HasUpload;

use stdClass;

/**
 * @ORM\Entity
 * @ORM\Table(name="hr_downloadables")
 */
class Downloadables
{
    use HasGeneratedID;
    use HasName;
    use HasNotes;
    use HasUpload;
    use TrackCreate;

    public function __construct()
    {
        $this->initTrackCreate();
    }

    public function toData()
    {

        $data = new stdClass();
        $this->dataHasGeneratedID($data);

        $data->name = $this->name;
        $data->notes = $this->notes;

        return $data;
    }

}
