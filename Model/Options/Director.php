<?php
namespace Magenest\Movie\Model\Options;
class Director implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magenest\Movie\Model\ResourceModel\Director\Collection
     */
    protected $directorCollection;

    /**
     * Director constructor.
     * @param \Magenest\Movie\Model\ResourceModel\Director\Collection $directorCollection
     */
    public function __construct(
        \Magenest\Movie\Model\ResourceModel\Director\Collection $directorCollection
    )
    {
        $this->directorCollection = $directorCollection;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        // TODO: Implement toOptionArray() method.
        $directors = $this->directorCollection->load();
        $options =[];

        foreach ($directors as $director){
            $options[] =[
                'value'=> $director->getdirectorId(),
                'label'=> $director->getName()
            ];
        }
        return $options;

    }
}