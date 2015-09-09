<?php

namespace oat\deploymentsTools\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ConsoleModel;
use Zend\View\Model\ViewModel;

class DeployController extends AbstractActionController
{

    const DATA_PATH = __DIR__ . '/../../../../data/';

    /**
     * Runs example phing file and returns
     *
     * @return ViewModel
     */
    public function runAction()
    {
        

        $parckageUrl = $this->params()->fromPost('package_url');
        $testParckageUrl = $this->params()->fromPost('test_package_url');
        $id = $this->params()->fromPost('build_id');
        
        $buildResult = $this
            ->getServiceLocator()
            ->get('BsbPhingService')
            ->build('test', array(
                'buildFile' => self::DATA_PATH . 'build.xml',
            ));

        $content = 'build resuld : ' . $buildResult;
        $content .= 'package_url : '  . $parckageUrl;
        $content .= 'test_package_url : '  . $testParckageUrl;
        $content .= 'build_id : ' . $id;
        
        file_put_contents(self::DATA_PATH . 'results.txt',  $content);
        
        
        $view = new ViewModel();
        $view->setVariable('process', $buildResult);

        return $view;
    }
    
    public function helpAction()
    {
        $model = new ConsoleModel();
        
        $model->setResult('No application found' . PHP_EOL);
        
        return $model;
    }
}
