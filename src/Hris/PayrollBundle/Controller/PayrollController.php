<?php

namespace Hris\PayrollBundle\Controller;

use Gist\TemplateBundle\Model\CrudController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;

use Hris\PayrollBundle\Entity\PayTaxMatrix;

use Hris\PayrollBundle\Entity\PayTaxRate;
use Hris\PayrollBundle\Entity\PayTaxStatus;
use Hris\PayrollBundle\Entity\PayPeriod;

use DateTime;

class PayrollController extends CrudController
{
	public function __construct()
	{
		$this->route_prefix = 'hris_payroll_view';
		$this->title = 'Payroll Record';

		$this->list_title = 'Payroll Record';
		$this->list_type = 'dynamic';
        $this->repo = 'HrisPayrollBundle:PayPayroll';
	}

    protected function getObjectLabel($object) 
    {
        if ($object == null){
            return '';
        }
    } 

    public function indexAction()
    {
        $this->checkAccess($this->route_prefix . '.view');

        $this->hookPreAction();

        $gl = $this->setupGridLoader();

        $params = $this->getViewParams('List');

        $twig_file = 'HrisPayrollBundle:Payroll:index.html.twig';

        $params['list_title'] = $this->list_title;
        $params['grid_cols'] = $gl->getColumns();

        return $this->render($twig_file, $params);
    }

    protected function newBaseClass() {
        return new PayPayroll();
    }

    protected function getGridJoins()
    {
        $grid = $this->get('gist_grid');
        return array(
            // $grid->newJoin('period', 'period', 'getPayrollPeriod'),
            $grid->newJoin('employee', 'employee', 'getEmployee'),

        );
    }

    protected function getGridColumns()
    {
        $grid = $this->get('gist_grid');
        return array( 
            $grid->newColumn('Employee', 'getDisplayName', 'last_name','employee'),
            $grid->newColumn('Payroll Period', 'getPayrollPeriod', '','o', array($this,'formatPaySchedule')),
            $grid->newColumn('Gross Pay', 'getTotal', 'total_amount','o', array($this,'formatPrice')),
        );
    }

    public function formatPaySchedule($payPeriod)
    {
        return $payPeriod->getStartDate()->format('m/d/Y').' - '.$payPeriod->getEndDate()->format('m/d/Y');
    }

    public function update($o, $data, $is_new = false)
    {

     
    }

    public function callbackGrid($id)
    {
        $params = array(
            'id' => $id,
            // 'route_edit' => $this->getRouteGen()->getEdit(),
            'prefix' => $this->route_prefix,
        );

        $this->padGridParams($params, $id);

        $engine = $this->get('templating');
        return $engine->render(
            'HrisPayrollBundle:Payroll:action.html.twig',
            $params
        );
    }

    protected function padFormParams(&$params, $object = null)
    {
        $payroll = $this->get('hris_payroll');

        $params['sched_opts'] = $payroll->getPaySchedPayrollOptions();
        

        return $params;
    }
}