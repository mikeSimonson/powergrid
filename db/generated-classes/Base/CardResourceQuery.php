<?php

namespace Base;

use \CardResource as ChildCardResource;
use \CardResourceQuery as ChildCardResourceQuery;
use \Exception;
use \PDO;
use Map\CardResourceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'card_resource' table.
 *
 *
 *
 * @method     ChildCardResourceQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCardResourceQuery orderByCardId($order = Criteria::ASC) Order by the card_id column
 * @method     ChildCardResourceQuery orderByResourceTypeId($order = Criteria::ASC) Order by the resource_type_id column
 *
 * @method     ChildCardResourceQuery groupById() Group by the id column
 * @method     ChildCardResourceQuery groupByCardId() Group by the card_id column
 * @method     ChildCardResourceQuery groupByResourceTypeId() Group by the resource_type_id column
 *
 * @method     ChildCardResourceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCardResourceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCardResourceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCardResourceQuery leftJoinResourceType($relationAlias = null) Adds a LEFT JOIN clause to the query using the ResourceType relation
 * @method     ChildCardResourceQuery rightJoinResourceType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ResourceType relation
 * @method     ChildCardResourceQuery innerJoinResourceType($relationAlias = null) Adds a INNER JOIN clause to the query using the ResourceType relation
 *
 * @method     ChildCardResourceQuery leftJoinCard($relationAlias = null) Adds a LEFT JOIN clause to the query using the Card relation
 * @method     ChildCardResourceQuery rightJoinCard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Card relation
 * @method     ChildCardResourceQuery innerJoinCard($relationAlias = null) Adds a INNER JOIN clause to the query using the Card relation
 *
 * @method     \ResourceTypeQuery|\CardQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCardResource findOne(ConnectionInterface $con = null) Return the first ChildCardResource matching the query
 * @method     ChildCardResource findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCardResource matching the query, or a new ChildCardResource object populated from the query conditions when no match is found
 *
 * @method     ChildCardResource findOneById(int $id) Return the first ChildCardResource filtered by the id column
 * @method     ChildCardResource findOneByCardId(int $card_id) Return the first ChildCardResource filtered by the card_id column
 * @method     ChildCardResource findOneByResourceTypeId(int $resource_type_id) Return the first ChildCardResource filtered by the resource_type_id column *

 * @method     ChildCardResource requirePk($key, ConnectionInterface $con = null) Return the ChildCardResource by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCardResource requireOne(ConnectionInterface $con = null) Return the first ChildCardResource matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCardResource requireOneById(int $id) Return the first ChildCardResource filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCardResource requireOneByCardId(int $card_id) Return the first ChildCardResource filtered by the card_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCardResource requireOneByResourceTypeId(int $resource_type_id) Return the first ChildCardResource filtered by the resource_type_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCardResource[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCardResource objects based on current ModelCriteria
 * @method     ChildCardResource[]|ObjectCollection findById(int $id) Return ChildCardResource objects filtered by the id column
 * @method     ChildCardResource[]|ObjectCollection findByCardId(int $card_id) Return ChildCardResource objects filtered by the card_id column
 * @method     ChildCardResource[]|ObjectCollection findByResourceTypeId(int $resource_type_id) Return ChildCardResource objects filtered by the resource_type_id column
 * @method     ChildCardResource[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CardResourceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CardResourceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'powergrid', $modelName = '\\CardResource', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCardResourceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCardResourceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCardResourceQuery) {
            return $criteria;
        }
        $query = new ChildCardResourceQuery();
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
     * @return ChildCardResource|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CardResourceTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CardResourceTableMap::DATABASE_NAME);
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
     * @return ChildCardResource A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, card_id, resource_type_id FROM card_resource WHERE id = :p0';
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
            /** @var ChildCardResource $obj */
            $obj = new ChildCardResource();
            $obj->hydrate($row);
            CardResourceTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCardResource|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCardResourceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CardResourceTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCardResourceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CardResourceTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCardResourceQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CardResourceTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CardResourceTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CardResourceTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the card_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCardId(1234); // WHERE card_id = 1234
     * $query->filterByCardId(array(12, 34)); // WHERE card_id IN (12, 34)
     * $query->filterByCardId(array('min' => 12)); // WHERE card_id > 12
     * </code>
     *
     * @see       filterByCard()
     *
     * @param     mixed $cardId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCardResourceQuery The current query, for fluid interface
     */
    public function filterByCardId($cardId = null, $comparison = null)
    {
        if (is_array($cardId)) {
            $useMinMax = false;
            if (isset($cardId['min'])) {
                $this->addUsingAlias(CardResourceTableMap::COL_CARD_ID, $cardId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cardId['max'])) {
                $this->addUsingAlias(CardResourceTableMap::COL_CARD_ID, $cardId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CardResourceTableMap::COL_CARD_ID, $cardId, $comparison);
    }

    /**
     * Filter the query on the resource_type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByResourceTypeId(1234); // WHERE resource_type_id = 1234
     * $query->filterByResourceTypeId(array(12, 34)); // WHERE resource_type_id IN (12, 34)
     * $query->filterByResourceTypeId(array('min' => 12)); // WHERE resource_type_id > 12
     * </code>
     *
     * @see       filterByResourceType()
     *
     * @param     mixed $resourceTypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCardResourceQuery The current query, for fluid interface
     */
    public function filterByResourceTypeId($resourceTypeId = null, $comparison = null)
    {
        if (is_array($resourceTypeId)) {
            $useMinMax = false;
            if (isset($resourceTypeId['min'])) {
                $this->addUsingAlias(CardResourceTableMap::COL_RESOURCE_TYPE_ID, $resourceTypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($resourceTypeId['max'])) {
                $this->addUsingAlias(CardResourceTableMap::COL_RESOURCE_TYPE_ID, $resourceTypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CardResourceTableMap::COL_RESOURCE_TYPE_ID, $resourceTypeId, $comparison);
    }

    /**
     * Filter the query by a related \ResourceType object
     *
     * @param \ResourceType|ObjectCollection $resourceType The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCardResourceQuery The current query, for fluid interface
     */
    public function filterByResourceType($resourceType, $comparison = null)
    {
        if ($resourceType instanceof \ResourceType) {
            return $this
                ->addUsingAlias(CardResourceTableMap::COL_RESOURCE_TYPE_ID, $resourceType->getId(), $comparison);
        } elseif ($resourceType instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CardResourceTableMap::COL_RESOURCE_TYPE_ID, $resourceType->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByResourceType() only accepts arguments of type \ResourceType or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ResourceType relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCardResourceQuery The current query, for fluid interface
     */
    public function joinResourceType($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ResourceType');

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
            $this->addJoinObject($join, 'ResourceType');
        }

        return $this;
    }

    /**
     * Use the ResourceType relation ResourceType object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ResourceTypeQuery A secondary query class using the current class as primary query
     */
    public function useResourceTypeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinResourceType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ResourceType', '\ResourceTypeQuery');
    }

    /**
     * Filter the query by a related \Card object
     *
     * @param \Card|ObjectCollection $card The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCardResourceQuery The current query, for fluid interface
     */
    public function filterByCard($card, $comparison = null)
    {
        if ($card instanceof \Card) {
            return $this
                ->addUsingAlias(CardResourceTableMap::COL_CARD_ID, $card->getId(), $comparison);
        } elseif ($card instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CardResourceTableMap::COL_CARD_ID, $card->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCard() only accepts arguments of type \Card or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Card relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCardResourceQuery The current query, for fluid interface
     */
    public function joinCard($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Card');

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
            $this->addJoinObject($join, 'Card');
        }

        return $this;
    }

    /**
     * Use the Card relation Card object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CardQuery A secondary query class using the current class as primary query
     */
    public function useCardQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCard($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Card', '\CardQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCardResource $cardResource Object to remove from the list of results
     *
     * @return $this|ChildCardResourceQuery The current query, for fluid interface
     */
    public function prune($cardResource = null)
    {
        if ($cardResource) {
            $this->addUsingAlias(CardResourceTableMap::COL_ID, $cardResource->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the card_resource table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CardResourceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CardResourceTableMap::clearInstancePool();
            CardResourceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CardResourceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CardResourceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CardResourceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CardResourceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CardResourceQuery
