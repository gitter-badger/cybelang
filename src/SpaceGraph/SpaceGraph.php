<?php

namespace MemMemov\SpaceGraph;

use MemMemov\Cybe\Graph;
use MemMemov\Cybe\GraphNode;
use MemMemov\Cybe\GraphSequence;
use MemMemov\Cybe\GraphValue;

class SpaceGraph implements Graph
{
    private $nodes;
    private $spaces;
    private $spaceNodes;

    public function __construct(
        Nodes $nodes,
        Spaces $spaces,
        SpaceNodes $spaceNodes
    ) {
        $this->nodes = $nodes;
        $this->spaces = $spaces;
        $this->spaceNodes = $spaceNodes;
    }



    public function provideCommonNode(string $toType, string $fromType, array $fromIds): SpaceNode
    {
        $toSpace = $this->spaces->provideSpace($toType);
        $fromSpace = $this->spaces->provideSpace($fromType);

        $idCount = count($ids);

        $spaceNodes = array_map(function(int $id) {
            return $this->spaceNodes->read($id);
        }, $ids);

        $commonNodes = array_filter(
            $this->nodes->commonNodes($ids),
            function(Node $node) use ($idCount, $space) {
                if (!$space->has($node)) {
                    return false;
                }
                if ($node->count() !== $idCount) {
                    return false;
                }
                return ;
            }
        );


        $commonIds = array_filter(
            $this->store->intersect($ids),
            function(int $commonId) use ($idCount) {
                return $this->store->countNode($commonId) === $idCount;
            }
        );

        $commonIdCount = count($commonIds);

        if (0 === $commonIdCount) {
            $commonId = $this->store->createNode();
            //$space->add($commonNode);
            array_map(function(Node $node) use ($commonNode) {
                $commonNode->addNode($node);
                $node->addNode($commonNode);
            }, $nodes);
        } elseif () {
            $idCount = count($ids);
            $countedCommonIds = [];
            foreach ($commonIds as $commonId) {
                if ($this->store->countNode($commonId) === $idCount) {
                    $countedCommonIds[] = $commonId;
                }
            }
            if () {

            }
            throw new \Exception('Multiple common nodes detected');
        }

        return new SpaceNode($commonId, $type, $this->graph, $this->spaces);
    }

    public function readNode(int $id): GraphNode
    {

    }

    public function сreateSequence(string $type, array $ids): GraphSequence
    {

    }

    public function readSequence(int $id): GraphSequence
    {

    }

    public function сreateValue(string $type, string $content): GraphValue
    {

    }

    public function readValue(int $id): GraphValue
    {

    }
}