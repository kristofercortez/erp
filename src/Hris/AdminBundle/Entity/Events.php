<?php

namespace Hris\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gist\CoreBundle\Template\Entity\HasGeneratedID;
use Gist\CoreBundle\Template\Entity\HasName;
use Gist\CoreBundle\Template\Entity\TrackCreate;

use stdClass;

/**
 * @ORM\Entity
 * @ORM\Table(name="hr_event")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="name", column=@ORM\Column(type="string", name="name", length=255, nullable=false)),
 * })
 */
class Events
{
    use HasGeneratedID;
    use HasName;
    use TrackCreate;

    /**
     * @ORM\ManyToOne(targetEntity="ValueTypes")
     * @ORM\JoinColumn(name="type", referencedColumnName="id")
     */
    protected $type;

    /** @ORM\Column(type="datetime") */
    protected $date_from;

    /** @ORM\Column(type="datetime") */
    protected $date_to;

    /** @ORM\Column(type="string", length=80) */
    protected $holiday_type;

    /** @ORM\Column(type="decimal", length=80, nullable=true) */
    protected $rate;

    /** @ORM\Column(type="boolean") */
    protected $is_paid;

    public function __construct()
    {
        $this->initTrackCreate();
        $this->initHasName();
    }

    /**
     * Set type
     *
     * @param \Hris\AdminBundle\Entity\ValueTypes $type
     *
     * @return Events
     */
    public function setType(\Hris\AdminBundle\Entity\ValueTypes $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Hris\AdminBundle\Entity\ValueTypes
     */
    public function getType()
    {
        return $this->type;
    }

    public function setRate($rate)
    {
        $this->rate = $rate;
        return $this;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function setIsPaid($is_paid)
    {
        $this->is_paid = $is_paid;

        return $this;
    }

    public function getIsPaid()
    {
        return $this->is_paid;
    }

    public function getRateFormatted()
    {
        if ($this->type->getID() == \Hris\AdminBundle\Utility\ValueTypes::PERCENT) {
            return $this->rate . '%';
        }
        return $this->rate;
    }

    public function setDateFrom($date_from)
    {
        $this->date_from = $date_from;
        return $this;
    }

    public function getDateFrom()
    {
        if ($this->date_from == null)
        {
            return $this->date_from;
        }
        else
        {
            return $this->date_from->format('F d, Y g:i A');
        }
    }

    public function getDateFrom2()
    {
            return $this->date_from;
    }

    public function setDateTo($date_to)
    {
        $this->date_to = $date_to;
        return $this;
    }

    public function getDateTo()
    {
        if ($this->date_to == null)
        {
            return $this->date_to;
        }
        else
        {
            return $this->date_to->format('F d, Y g:i A');
        }
    }

    public function getDateTo2()
    {
            return $this->date_to;
    }

    public function getStartTime()
    {
        return $this->date_from->format('h:i A');
    }

    public function getEndTime()
    {
        return $this->date_to->format('h:i A');
    }

    public function setHolidayType($holiday_type)
    {
        $this->holiday_type = $holiday_type;
        return $this;
    }

    public function getHolidayType()
    {
        return $this->holiday_type;
    }

    public function toData()
    {
        $data = new \stdClass();
        $this->dataHasGeneratedID($data);
        $this->dataTrackCreate($data);
        $this->dataHasName($data);
        return $data;
    }


}
