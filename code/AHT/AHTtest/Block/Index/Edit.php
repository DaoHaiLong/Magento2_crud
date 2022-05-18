<?php
namespace AHT\AHTtest\Block\Index;

class Edit extends \Magento\Framework\View\Element\Template
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
     * @param \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @param \AHT\AHTtest\Model\TableFactory
     */
    private $tableFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \AHT\AHTtest\Model\TableRepository $tableRepository,
        \AHT\AHTtest\Model\TableFactory $tableFactory,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->tableRepository = $tableRepository;
        $this->tableFactory = $tableFactory;
        $this->registry = $registry;
        parent::__construct($context, $data);
    }
    // public function execute()
    // {
    //      return $this->_pageFactory->create();
    // }
    public function getTable(){

        $id=$this->registry->registry('editid');
        // $tablecreate = $this->tableFactory->create();
        if($id !=''){
            $table=$this->tableRepository->get($id);
   
            return $table;
        }else{
              return null;
        }
        
    }
}
