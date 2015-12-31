<?php

namespace Base;

use \Card as ChildCard;
use \CardQuery as ChildCardQuery;
use \Exception;
use \PDO;
use Map\CardTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'card' table.
 *
 *
 *
 * @method     ChildCardQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCardQuery orderByStartingAuctionPrice($order = Criteria::ASC) Order by the starting_auction_price column
 * @method     ChildCardQuery orderByResourceCost($order = Criteria::ASC) Order by the resource_cost column
 * @method     ChildCardQuery orderByPowerOutput($order = Criteria::ASC) Order by the power_output column
 * @method     ChildCardQuery orderByTriggerStep($order = Criteria::ASC) Order by the trigger_step column
 * @method     ChildCardQuery orderByCardSetId($order = Criteria::ASC) Order by the card_set_id column
 *
 * @method     ChildCardQuery groupById() Group by the id column
 * @method     ChildCardQuery groupByStartingAuctionPrice() Group by the starting_auction_price column
 * @method     ChildCardQuery groupByResourceCost() Group by the resource_cost column
 * @method     ChildCardQuery groupByPowerOutput() Group by the power_output column
 * @method     ChildCardQuery groupByTriggerStep() Group by the trigger_step column
 * @method     ChildCardQuery groupByCardSetId() Group by the card_set_id column
 *
 * @method     ChildCardQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCardQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCardQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCardQuery leftJoinCardSet($relationAlias = null) Adds a LEFT JOIN clause to the query using the CardSet relation
 * @method     ChildCardQuery rightJoinCardSet($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CardSet relation
 * @method     ChildCardQuery innerJoinCardSet($relationAlias = null) Adds a INNER JOIN clause to the query using the CardSet relation
 *
 * @method     ChildCardQuery leftJoinCardResourceType($relationAlias = null) Adds a LEFT JOIN clause to the query using the CardResourceType relation
 * @method     ChildCardQuery rightJoinCardResourceType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CardResourceType relation
 * @method     ChildCardQuery innerJoinCardResourceType($relationAlias = null) Adds a INNER JOIN clause to the query using the CardResourceType relation
 *
 * @method     ChildCardQuery leftJoinGameCard($relationAlias = null) Adds a LEFT JOIN clause to the query using the GameCard relation
 * @method     ChildCardQuery rightJoinGameCard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GameCard relation
 * @method     ChildCardQuery innerJoinGameCard($relationAlias = null) Adds a INNER JOIN clause to the query using the GameCard relation
 *
 * @method     \CardSetQuery|\CardResourceQuery|\GameCardQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCard findOne(ConnectionInterface $con = null) Return the first ChildCard matching the query
 * @method     ChildCard findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCard matching the query, or a new ChildCard object populated from the query conditions when no match is found
 *
 * @method     ChildCard findOneById(int $id) Return the first ChildCard filtered by the id column
 * @method     ChildCard findOneByStartingAuctionPrice(int $starting_auction_price) Return the first ChildCard filtered by the starting_auction_price column
 * @method     ChildCard findOneByResourceCost(int $resource_cost) Return the first ChildCard filtered by the resource_cost column
 * @method     ChildCard findOneByPowerOutput(int $power_output) Return the first ChildCard filtered by the power_output column
 * @method     ChildCard findOneByTriggerStep(int $trigger_step) Return the first ChildCard filtered by the trigger_step column
 * @method     ChildCard findOneByCardSetId(int $card_set_id) Return the first ChildCard filtered by the card_set_id column *

 * @method     ChildCard requirePk($key, ConnectionInterface $con = null) Return the ChildCard by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCard requireOne(ConnectionInterface $con = null) Return the first ChildCard matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCard requireOneById(int $id) Return the first ChildCard filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCard requireOneByStartingAuctionPrice(int $starting_auction_price) Return the first ChildCard filtered by the starting_auction_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCard requireOneByResourceCost(int $resource_cost) Return the first ChildCard filtered by the resource_cost column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCard requireOneByPowerOutput(int $power_output) Return the first ChildCard filtered by the power_output column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCard requireOneByTriggerStep(int $trigger_step) Return the first ChildCard filtered by the trigger_step column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCard requireOneByCardSetId(int $card_set_id) Return the first ChildCard filtered by the card_set_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCard[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCard objects based on current ModelCriteria
 * @method     ChildCard[]|ObjectCollection findById(int $id) Return ChildCard objects filtered by the id column
 * @method     ChildCard[]|ObjectCollection findByStartingAuctionPrice(int $starting_auction_price) Return ChildCard objects filtered by the starting_auction_price column
 * @method     ChildCard[]|ObjectCollection findByResourceCost(int $resource_cost) Return ChildCard objects filtered by the resource_cost column
 * @method     ChildCard[]|ObjectCollection findByPowerOutput(int $power_output) Return ChildCard objects filtered by the power_output column
 * @method     ChildCard[]|ObjectCollection findByTriggerStep(int $trigger_step) Return ChildCard objects filtered by the trigger_step column
 * @method     ChildCard[]|ObjectCollection findByCardSetId(int $card_set_id) Return ChildCard objects filtered by the card_set_id column
 * @method     ChildCard[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CardQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CardQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'powergrid', $modelName = '\\Card', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCardQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCardQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCardQuery) {
            return $criteria;
        }
        $query = new ChildCardQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCard|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CardTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CardTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCard A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, starting_auction_price, resource_cost, power_output, trigger_step, card_set_id FROM card WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCard $obj */
            $obj = new ChildCard();
            $obj->hydrate($row);
            CardTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildCard|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CardTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CardTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CardTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CardTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CardTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the starting_auction_price column
     *
     * Example usage:
     * <code>
     * $query->filterByStartingAuctionPrice(1234); // WHERE starting_auction_price = 1234
     * $query->filterByStartingAuctionPrice(array(12, 34)); // WHERE starting_auction_price IN (12, 34)
     * $query->filterByStartingAuctionPrice(array('min' => 12)); // WHERE starting_auction_price > 12
     * </code>
     *
     * @param     mixed $startingAuctionPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function filterByStartingAuctionPrice($startingAuctionPrice = null, $comparison = null)
    {
        if (is_array($startingAuctionPrice)) {
            $useMinMax = false;
            if (isset($startingAuctionPrice['min'])) {
                $this->addUsingAlias(CardTableMap::COL_STARTING_AUCTION_PRICE, $startingAuctionPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startingAuctionPrice['max'])) {
                $this->addUsingAlias(CardTableMap::COL_STARTING_AUCTION_PRICE, $startingAuctionPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CardTableMap::COL_STARTING_AUCTION_PRICE, $startingAuctionPrice, $comparison);
    }

    /**
     * Filter the query on the resource_cost column
     *
     * Example usage:
     * <code>
     * $query->filterByResourceCost(1234); // WHERE resource_cost = 1234
     * $query->filterByResourceCost(array(12, 34)); // WHERE resource_cost IN (12, 34)
     * $query->filterByResourceCost(array('min' => 12)); // WHERE resource_cost > 12
     * </code>
     *
     * @param     mixed $resourceCost The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function filterByResourceCost($resourceCost = null, $comparison = null)
    {
        if (is_array($resourceCost)) {
            $useMinMax = false;
            if (isset($resourceCost['min'])) {
                $this->addUsingAlias(CardTableMap::COL_RESOURCE_COST, $resourceCost['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($resourceCost['max'])) {
                $this->addUsingAlias(CardTableMap::COL_RESOURCE_COST, $resourceCost['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CardTableMap::COL_RESOURCE_COST, $resourceCost, $comparison);
    }

    /**
     * Filter the query on the power_output column
     *
     * Example usage:
     * <code>
     * $query->filterByPowerOutput(1234); // WHERE power_output = 1234
     * $query->filterByPowerOutput(array(12, 34)); // WHERE power_output IN (12, 34)
     * $query->filterByPowerOutput(array('min' => 12)); // WHERE power_output > 12
     * </code>
     *
     * @param     mixed $powerOutput The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function filterByPowerOutput($powerOutput = null, $comparison = null)
    {
        if (is_array($powerOutput)) {
            $useMinMax = false;
            if (isset($powerOutput['min'])) {
                $this->addUsingAlias(CardTableMap::COL_POWER_OUTPUT, $powerOutput['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($powerOutput['max'])) {
                $this->addUsingAlias(CardTableMap::COL_POWER_OUTPUT, $powerOutput['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CardTableMap::COL_POWER_OUTPUT, $powerOutput, $comparison);
    }

    /**
     * Filter the query on the trigger_step column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerStep(1234); // WHERE trigger_step = 1234
     * $query->filterByTriggerStep(array(12, 34)); // WHERE trigger_step IN (12, 34)
     * $query->filterByTriggerStep(array('min' => 12)); // WHERE trigger_step > 12
     * </code>
     *
     * @param     mixed $triggerStep The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function filterByTriggerStep($triggerStep = null, $comparison = null)
    {
        if (is_array($triggerStep)) {
            $useMinMax = false;
            if (isset($triggerStep['min'])) {
                $this->addUsingAlias(CardTableMap::COL_TRIGGER_STEP, $triggerStep['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($triggerStep['max'])) {
                $this->addUsingAlias(CardTableMap::COL_TRIGGER_STEP, $triggerStep['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CardTableMap::COL_TRIGGER_STEP, $triggerStep, $comparison);
    }

    /**
     * Filter the query on the card_set_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCardSetId(1234); // WHERE card_set_id = 1234
     * $query->filterByCardSetId(array(12, 34)); // WHERE card_set_id IN (12, 34)
     * $query->filterByCardSetId(array('min' => 12)); // WHERE card_set_id > 12
     * </code>
     *
     * @see       filterByCardSet()
     *
     * @param     mixed $cardSetId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function filterByCardSetId($cardSetId = null, $comparison = null)
    {
        if (is_array($cardSetId)) {
            $useMinMax = false;
            if (isset($cardSetId['min'])) {
                $this->addUsingAlias(CardTableMap::COL_CARD_SET_ID, $cardSetId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cardSetId['max'])) {
                $this->addUsingAlias(CardTableMap::COL_CARD_SET_ID, $cardSetId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CardTableMap::COL_CARD_SET_ID, $cardSetId, $comparison);
    }

    /**
     * Filter the query by a related \CardSet object
     *
     * @param \CardSet|ObjectCollection $cardSet The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCardQuery The current query, for fluid interface
     */
    public function filterByCardSet($cardSet, $comparison = null)
    {
        if ($cardSet instanceof \CardSet) {
            return $this
                ->addUsingAlias(CardTableMap::COL_CARD_SET_ID, $cardSet->getId(), $comparison);
        } elseif ($cardSet instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CardTableMap::COL_CARD_SET_ID, $cardSet->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCardSet() only accepts arguments of type \CardSet or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CardSet relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function joinCardSet($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CardSet');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CardSet');
        }

        return $this;
    }

    /**
     * Use the CardSet relation CardSet object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CardSetQuery A secondary query class using the current class as primary query
     */
    public function useCardSetQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCardSet($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CardSet', '\CardSetQuery');
    }

    /**
     * Filter the query by a related \CardResource object
     *
     * @param \CardResource|ObjectCollection $cardResource the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCardQuery The current query, for fluid interface
     */
    public function filterByCardResourceType($cardResource, $comparison = null)
    {
        if ($cardResource instanceof \CardResource) {
            return $this
                ->addUsingAlias(CardTableMap::COL_ID, $cardResource->getCardId(), $comparison);
        } elseif ($cardResource instanceof ObjectCollection) {
            return $this
                ->useCardResourceTypeQuery()
                ->filterByPrimaryKeys($cardResource->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCardResourceType() only accepts arguments of type \CardResource or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CardResourceType relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function joinCardResourceType($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CardResourceType');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CardResourceType');
        }

        return $this;
    }

    /**
     * Use the CardResourceType relation CardResource object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CardResourceQuery A secondary query class using the current class as primary query
     */
    public function useCardResourceTypeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCardResourceType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CardResourceType', '\CardResourceQuery');
    }

    /**
     * Filter the query by a related \GameCard object
     *
     * @param \GameCard|ObjectCollection $gameCard the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCardQuery The current query, for fluid interface
     */
    public function filterByGameCard($gameCard, $comparison = null)
    {
        if ($gameCard instanceof \GameCard) {
            return $this
                ->addUsingAlias(CardTableMap::COL_ID, $gameCard->getCardId(), $comparison);
        } elseif ($gameCard instanceof ObjectCollection) {
            return $this
                ->useGameCardQuery()
                ->filterByPrimaryKeys($gameCard->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGameCard() only accepts arguments of type \GameCard or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GameCard relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function joinGameCard($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GameCard');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'GameCard');
        }

        return $this;
    }

    /**
     * Use the GameCard relation GameCard object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GameCardQuery A secondary query class using the current class as primary query
     */
    public function useGameCardQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGameCard($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GameCard', '\GameCardQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCard $card Object to remove from the list of results
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function prune($card = null)
    {
        if ($card) {
            $this->addUsingAlias(CardTableMap::COL_ID, $card->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the card table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CardTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CardTableMap::clearInstancePool();
            CardTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CardTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CardTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CardTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CardTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CardQuery
