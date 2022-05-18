<?php
namespace AHT\AHTtest\Controller\Index;

class delete extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @param \Magento\Framework\App\Request\Http
     */
    private $request;

    /**
     * @param \AHT\AHTtest\Model\TableRepository
     */
    private $tableRepository;

    /**
     * @param \AHT\AHTtest\Model\TableFactory
     */
    private $tableFactory;

    /**
     * @param \Magento\Framework\App\Cache\TypeListInterface
     */
    private $typeList;

    /**
     * @param \Magento\Framework\App\Cache\Frontend\Pool
     */
    private $pool;

    /**
     * @param \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
       \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\App\Request\Http $request,
        \AHT\AHTtest\Model\TableRepository $tableRepository,
        \AHT\AHTtest\Model\TableFactory $tableFactory,
        \Magento\Framework\App\Cache\TypeListInterface $typeList,
        \Magento\Framework\App\Cache\Frontend\Pool $pool,
        \Magento\Framework\Registry $registry
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->request = $request;
        $this->tableRepository = $tableRepository;
        $this->tableFactory = $tableFactory;
        $this->typeList = $typeList;
        $this->pool = $pool;
        $this->registry = $registry;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id=$this->request->getParam('id');
        // $this->tableFactory->create();
        // $this->registry->register('editid',$id);
        $this->tableRepository->deleteById($id);
        $this->flushCache();
        return $this->_redirect('haha/index/index');
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
