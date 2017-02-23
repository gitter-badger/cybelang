<?php

namespace MemMemov\SpaceGraph;

class Nodes
{
    private $store;
    /** @var int[] */
    private $cache;

    public function __construct(
        Store $store
    ) {
        $this->store = $store;
        $this->cache = [];
    }

    public function create(): Node
    {
        $id = $this->store->createNode();
        $node = new Node($id, [], $this->store);
        $this->cache[$id] = $node;

        return $node;
    }

    public function createCommonNode(array $nodes): Node
    {
        $commonNode = $nodes->create();

        foreach ($nodes as $node) {
            $node->add($commonNode);
            $commonNode->add($node);
        }

        return $commonNode;
    }

    public function read(int $id): Node
    {
        if (array_key_exists($id, $this->cache)) {
            return $this->cache[$id];
        }

        $ids = $this->store->readNode($id);
        $node = new Node($id, $ids, $this->store);
        $this->cache[$id] = $node;

        return $node;
    }

    /**
     * @param int[] $ids
     * @return Node[]
     */
    public function readMany(array $ids): array
    {
        $nodes = [];
        foreach ($ids as $id) {
            $nodes[] = $this->read($id);
        }

        return $nodes;
    }

    public function nodeForValue(string $value): Node
    {
        $id = $this->store->provideNode($value);

        return $this->read($id);
    }

    public function valueForNode(Node $node): string
    {
        return $this->store->readValue($node->id());
    }

    /**
     * @param int[] $ids
     * @return Node[]
     */
    public function commonNodes(array $ids): array
    {
        return array_map(function(int $id) {
            return $this->read($id);
        }, $this->store->commonNodes($ids));
    }

    /**
     * @param Node $selectorNode
     * @param Node[] $nodes
     * @return Node[]
     */
    public function filter(Node $selectorNode, array $nodes): array
    {
        $selectedNodes = [];
        foreach ($nodes as $node) {
            if ($node->has($selectorNode)) {
                $selectedNodes[] = $node;
            }
        }

        return $selectedNodes;
    }
}