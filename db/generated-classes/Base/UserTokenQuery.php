<?php

namespace Base;

use \UserToken as ChildUserToken;
use \UserTokenQuery as ChildUserTokenQuery;
use \Exception;
use \PDO;
use Map\UserTokenTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'user_token' table.
 *
 *
 *
 * @method     ChildUserTokenQuery orderByTokenString($order = Criteria::ASC) Order by the token_string column
 * @method     ChildUserTokenQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildUserTokenQuery orderByExpirationDate($order = Criteria::ASC) Order by the expiration_date column
 *
 * @method     ChildUserTokenQuery groupByTokenString() Group by the token_string column
 * @method     ChildUserTokenQuery groupByUserId() Group by the user_id column
 * @method     ChildUserTokenQuery groupByExpirationDate() Group by the expiration_date column
 *
 * @method     ChildUserTokenQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserTokenQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserTokenQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserTokenQuery leftJoinTokenUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the TokenUser relation
 * @method     ChildUserTokenQuery rightJoinTokenUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TokenUser relation
 * @method     ChildUserTokenQuery innerJoinTokenUser($relationAlias = null) Adds a INNER JOIN clause to the query using the TokenUser relation
 *
 * @method     \UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUserToken findOne(ConnectionInterface $con = null) Return the first ChildUserToken matching the query
 * @method     ChildUserToken findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUserToken matching the query, or a new ChildUserToken object populated from the query conditions when no match is found
 *
 * @method     ChildUserToken findOneByTokenString(string $token_string) Return the first ChildUserToken filtered by the token_string column
 * @method     ChildUserToken findOneByUserId(int $user_id) Return the first ChildUserToken filtered by the user_id column
 * @method     ChildUserToken findOneByExpirationDate(string $expiration_date) Return the first ChildUserToken filtered by the expiration_date column *

 * @method     ChildUserToken requirePk($key, ConnectionInterface $con = null) Return the ChildUserToken by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserToken requireOne(ConnectionInterface $con = null) Return the first ChildUserToken matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserToken requireOneByTokenString(string $token_string) Return the first ChildUserToken filtered by the token_string column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserToken requireOneByUserId(int $user_id) Return the first ChildUserToken filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserToken requireOneByExpirationDate(string $expiration_date) Return the first ChildUserToken filtered by the expiration_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserToken[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUserToken objects based on current ModelCriteria
 * @method     ChildUserToken[]|ObjectCollection findByTokenString(string $token_string) Return ChildUserToken objects filtered by the token_string column
 * @method     ChildUserToken[]|ObjectCollection findByUserId(int $user_id) Return ChildUserToken objects filtered by the user_id column
 * @method     ChildUserToken[]|ObjectCollection findByExpirationDate(string $expiration_date) Return ChildUserToken objects filtered by the expiration_date column
 * @method     ChildUserToken[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserTokenQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UserTokenQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'powergrid', $modelName = '\\UserToken', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserTokenQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserTokenQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserTokenQuery) {
            return $criteria;
        }
        $query = new ChildUserTokenQuery();
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
     * @return ChildUserToken|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UserTokenTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTokenTableMap::DATABASE_NAME);
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
     * @return ChildUserToken A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT token_string, user_id, expiration_date FROM user_token WHERE token_string = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildUserToken $obj */
            $obj = new ChildUserToken();
            $obj->hydrate($row);
            UserTokenTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildUserToken|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUserTokenQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserTokenTableMap::COL_TOKEN_STRING, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserTokenQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserTokenTableMap::COL_TOKEN_STRING, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the token_string column
     *
     * Example usage:
     * <code>
     * $query->filterByTokenString('fooValue');   // WHERE token_string = 'fooValue'
     * $query->filterByTokenString('%fooValue%'); // WHERE token_string LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tokenString The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserTokenQuery The current query, for fluid interface
     */
    public function filterByTokenString($tokenString = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tokenString)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tokenString)) {
                $tokenString = str_replace('*', '%', $tokenString);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTokenTableMap::COL_TOKEN_STRING, $tokenString, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see       filterByTokenUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserTokenQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(UserTokenTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(UserTokenTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTokenTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the expiration_date column
     *
     * Example usage:
     * <code>
     * $query->filterByExpirationDate('2011-03-14'); // WHERE expiration_date = '2011-03-14'
     * $query->filterByExpirationDate('now'); // WHERE expiration_date = '2011-03-14'
     * $query->filterByExpirationDate(array('max' => 'yesterday')); // WHERE expiration_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $expirationDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserTokenQuery The current query, for fluid interface
     */
    public function filterByExpirationDate($expirationDate = null, $comparison = null)
    {
        if (is_array($expirationDate)) {
            $useMinMax = false;
            if (isset($expirationDate['min'])) {
                $this->addUsingAlias(UserTokenTableMap::COL_EXPIRATION_DATE, $expirationDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expirationDate['max'])) {
                $this->addUsingAlias(UserTokenTableMap::COL_EXPIRATION_DATE, $expirationDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTokenTableMap::COL_EXPIRATION_DATE, $expirationDate, $comparison);
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUserTokenQuery The current query, for fluid interface
     */
    public function filterByTokenUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(UserTokenTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserTokenTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTokenUser() only accepts arguments of type \User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TokenUser relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserTokenQuery The current query, for fluid interface
     */
    public function joinTokenUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TokenUser');

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
            $this->addJoinObject($join, 'TokenUser');
        }

        return $this;
    }

    /**
     * Use the TokenUser relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserQuery A secondary query class using the current class as primary query
     */
    public function useTokenUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTokenUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TokenUser', '\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUserToken $userToken Object to remove from the list of results
     *
     * @return $this|ChildUserTokenQuery The current query, for fluid interface
     */
    public function prune($userToken = null)
    {
        if ($userToken) {
            $this->addUsingAlias(UserTokenTableMap::COL_TOKEN_STRING, $userToken->getTokenString(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user_token table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTokenTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserTokenTableMap::clearInstancePool();
            UserTokenTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTokenTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserTokenTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UserTokenTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UserTokenTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UserTokenQuery
