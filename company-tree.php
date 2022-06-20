<?php

class Company
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @var array
     */
    protected array $children = [];

    /**
     * @var array
     */
    protected array $attributes = [];

    /**
     * Company constructor.
     *
     * @param string $id
     * @param array $attributes
     */
    public function __construct(string $id, array $attributes)
    {
        $this->id = $id;
        $this->attributes = $attributes;
    }

    /**
     * Adds the given node to this node's children.
     *
     * @param  $child
     */
    public function addChild($child)
    {
        $this->children[] = $child;

        $child->attributes['parentId'] = $this->id;
    }


    public function getParent()
    {
        return $this->parent ?? null;
    }

    public function getChildren()
    {
        return $this->children;
    }
    /**
     * @var array|array[]
     */
    protected array $travelData = [];

    /**
     * @var array
     */
    protected static array $costs = [];

    /**
     * @param array|array[] $travelData
     */
    public function setTravelData(array $travelData)
    {
        $this->travelData = $travelData;
    }

    /**
     * @return float|int
     */
    public function getTravelCost()
    {
        $prices = array_column($this->travelData, 'price');

        return array_sum($prices);
    }

    /**
     * @return float|int
     */
    public function getTotalCost()
    {
        if (isset(static::$costs[$this->id])) {
            return static::$costs[$this->id];
        }

        return static::$costs[$this->id] = array_reduce(
            $this->getChildren(),
            static function ($cost, $child) {
                return $cost + $child->getTotalCost();
            },
            $this->getTravelCost()
        );
    }

    public function toArray()
    {
        $array = $this->attributes;

        $array['children'] = array_map(
            static function ($child) {
                return $child->toArray();
            },
            $this->children
        );

        return [
            'id' => $array['id'],
            'name' => $array['name'],
            'cost' => $this->getTotalCost(),
            'children' => $array['children'],
        ];
    }

    public static function getData()
    {
        $url = "https://5f27781bf5d27e001612e057.mockapi.io/webprovise/companies";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($curl);
        $companies = json_decode($resp, true);

        return $companies ?? [];
    }
}

class Travel
{
    public static function getData(): array
    {
        $url = "https://5f27781bf5d27e001612e057.mockapi.io/webprovise/travels";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($curl);
        $travels = json_decode($resp, true);

        return $travels ?? [];
    }

    public static function groupData(array $elements): array
    {
        $data = [];

        foreach ($elements as $element) {
            if (!isset($data[$element['companyId']])) {
                $data[$element['companyId']] = [$element['id'] => $element];
            } else {
                $data[$element['companyId']][$element['id']] = $element;
            }
        }

        return $data;
    }
}

class CompanyTree
{
    /**
     * @var array|Node[]
     */
    protected array $nodes;

    /**
     * @var array|array[]
     */
    protected array $travelDataList;

    /**
     * Tree constructor.
     *
     * @param array $elements
     * @param array $travelDataList
     */
    public function __construct(array $elements, array $travelDataList)
    {
        $this->travelDataList = Travel::groupData($travelDataList);

        $this->buildNodes($elements);
    }

    public function getRootNode()
    {
        return $this->getRootNodes()[0] ?? null;
    }

    /**
     * @return Node[]
     */
    public function getRootNodes(): array
    {
        return $this->nodes['0']->getChildren();
    }

    /**
     * @param array $elements
     * @param string $rootId
     * @return void
     */
    private function buildNodes(array $elements, $rootId = '0'): void
    {
        $this->nodes[$rootId] = new Company($rootId, []);
        $children = [];

        foreach ($elements as $element) {
            $id = $element['id'];
            $this->nodes[$id] = new Company($id, $element);

            if (isset($this->travelDataList[$id])) {
                $this->nodes[$id]->setTravelData($this->travelDataList[$id]);
            }

            if (empty($children[$element['parentId']])) {
                $children[$element['parentId']] = [$id];
            } else {
                $children[$element['parentId']][] = $id;
            }
        }

        foreach ($children as $parentId => $childIds) {
            foreach ($childIds as $id) {
                if (isset($this->nodes[$parentId]) && $this->nodes[$parentId] !== $this->nodes[$id]) {
                    $this->nodes[$parentId]->addChild($this->nodes[$id]);
                }
            }
        }
    }
}

class TestScript
{
    public function execute(): void
    {
        $start = microtime(true);

        $travelData = Travel::getData();
        $companyData = Company::getData();
        $tree = new CompanyTree($companyData, $travelData);

        echo '<pre>' . print_r($tree->getRootNode()->toArray(), true) . '</pre>';
        // file_put_contents('result.txt', print_r($tree->getRootNode()->toArray(), true));
        echo 'Total time: ' . (microtime(true) - $start);
    }
}

(new TestScript())->execute();