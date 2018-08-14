<?php

namespace TaskManagementBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class TaskManagementBundle extends AbstractPimcoreBundle
{
    public function getJsPaths()
    {
        return [
            '/bundles/taskmanagement/js/pimcore/startup.js'
        ];
    }

    public function getCssPaths()
    {
        return [
            '/bundles/taskmanagement/css/style.css'
        ];
    }
}

