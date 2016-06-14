<?php

use Puko\Core\Backdoor\Data;
use Puko\Core\Presentation\Json\Service;
use Puko\Util\DateAndTime;

/**
 * Class Example
 * #PageTitle Welcome To Puko
 */
class Example extends Service
{

    private $id;

    function __construct($vars)
    {
        parent::__construct();
        $this->id = $vars;
    }

    function Main()
    {
        if (!$this->PukoAuthObject->IsAuthenticated()) {
            return array(
                'PageTitle' => 'Puko Framework',
                'Welcome' => 'Welcome To Puko Framework NOT AUTHENTICATED',
            );
        } else {
            return array(
                'PageTitle' => 'Puko Framework',
                'Welcome' => 'AUTHENTICATED',
            );
        }
    }

    /**
     * #PageTitle Login ke Aplikasi
     */
    function Login()
    {
        $this->PukoAuthObject->Authenticate('d', 'v');
    }

    /**
     * #PageTitle Upload File Anda
     */
    function FileUpload()
    {
        $vars = array();
        $vars['PageTitle'] = 'Upload File';

        $dataSubmit = isset($_POST['_submit']);
        if ($dataSubmit) {
            Data::To('filex')->Save(
                array(
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'file' => $_FILES['foto']['tmp_name']
                )
            );
        }
        return $vars;
    }

    function DateInput()
    {
        $da = new DateAndTime();

        Data::To('TanggalDetil')->Save(
            array(
                'Tanggal' => $da->NowDateTime(),
                'nama' => 'test apps'
            )
        );
    }

    function NoAccess()
    {
        echo 'koplax login aja salah';
    }

}