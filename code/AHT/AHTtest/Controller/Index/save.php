<?php

namespace AHT\AHTtest\Controller\Index;

class save extends \Magento\Framework\App\Action\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @param \AHT\AHTtest\Model\TableRepository
     */
    private $tableRepository;

    /**
     * @param \AHT\AHTtest\Model\Table
     */
    private $tableFactory;

    /**
     * @param \Magento\Framework\App\RequestInterface
     */
    private $request;

    /**
     * @param \Magento\Framework\App\Cache\TypeListInterface
     */
    private $typeList;

    /**
     * @param \Magento\Framework\App\Cache\Frontend\Pool
     */
    private $pool;

    /**
     * @param \Magento\Framework\Controller\ResultFactory
     */
    // protected $resultFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \AHT\AHTtest\Model\TableRepository $tableRepository,
        \AHT\AHTtest\Model\TableFactory $tableFactory,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\App\Cache\TypeListInterface $typeList,
        \Magento\Framework\App\Cache\Frontend\Pool $pool
        // \Magento\Framework\Controller\ResultFactory $resultFactory

    ) {
        $this->_pageFactory = $pageFactory;
        $this->tableRepository = $tableRepository;
        $this->tableFactory = $tableFactory;
        $this->request = $request;
        $this->typeList = $typeList;
        $this->pool = $pool;
        // $this->resultFactory = $resultFactory;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->request->getPostValue();
        extract($data);
        $tablecreate = $this->tableFactory->create();

        $tablecreate->setName($name);
        $tablecreate->setAge($age);
        if(isset($table_id)){
            $tablecreate->setTableId($table_id);
           
            // $this->tableRepository->save($tablecreate);
        }
        $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        
        if ($this->tableRepository->save($tablecreate)) {
            $redirect->setUrl('index');
        } else {
            $redirect->setUrl('create');
        }
        $this->flushCache();
        return $redirect;
    }
    public function flushCache()
    {
        $_types = [
            'config',
            'layout',
            'block_html',
            'collections',
            'reflection',
            'db_ddl',
            'eav',
            'config_integration',
            'config_integration_api',
            'full_page',
            'translate',
            'config_webservice'
        ];

        foreach ($_types as $type) {
            $this->typeList->cleanType($type);
        }
        foreach ($this->pool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }
    }
}
