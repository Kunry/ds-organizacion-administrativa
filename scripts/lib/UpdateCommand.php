<?php

require_once('Config.php');

use ConsoleKit\Widgets\ProgressBar;

/**
 * Actualiza datapackage.json
 *
 */
class UpdateCommand extends ConsoleKit\Command
{

    /**
     * Actualiza datapackage.json
     *
     */
    public function execute(array $args, array $options = array())
    {
        $datapackageNew = Config::$datapackage;

        $datapackageNew['last_updated']=date('Y-m-d ');

        if (!isset($options['nojson']) && !isset($options['n'])){
            foreach ( Config::$datapackage['resources'] as $resource){
                $resource['format'] = 'json';
                $resource['path'] = array_shift(explode('.',$resource['path'])) . ".json";
                $datapackageNew['resources'][]=$resource;
            }
        }


        //Nueva version
        if (file_exists(BASE_PATH . DS . "datapackage.json")) {
            $datapackageOld = json_decode(file_get_contents(BASE_PATH . DS . "datapackage.json"));
            if (!empty($datapackageOld->version)) {
                $datapackageNew['version'] = $datapackageOld->version;
                $datapackageNew['version']++;
            } else {
                $datapackageNew['version']="0.0.1";
            }
        }

        file_put_contents(BASE_PATH . DS . "datapackage.json", json_encode($datapackageNew,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    }


}