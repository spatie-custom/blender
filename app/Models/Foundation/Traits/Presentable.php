<?php

namespace App\Models\Foundation\Traits;

use Exception;

trait Presentable
{
    /**
     * @var string
     */
    protected $presenter;

    /**
     * @var mixed
     */
    protected $presenterInstance;

    /**
     * @throws Exception
     *
     * @return mixed
     */
    public function present()
    {
        if (!$this->presenter) {
            $this->presenter = 'App\\Models\\Presenters\\'.class_basename($this).'Presenter';
        }

        if (!class_exists($this->presenter)) {
            throw new Exception('Presenter '.$this->presenter.' not found');
        }

        if (!$this->presenterInstance) {
            $this->presenterInstance = new $this->presenter($this);
        }

        return $this->presenterInstance;
    }
}
