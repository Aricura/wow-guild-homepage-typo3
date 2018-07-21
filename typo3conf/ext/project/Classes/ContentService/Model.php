<?php

declare(strict_types=1);

namespace Project\Classes\ContentService;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\AbstractController;

/**
 * Abstract base model for all persistent data.
 */
abstract class Model extends AbstractController
{

	/**
	 * Database table name.
	 *
	 * @var string
	 */
	protected $table;
	/**
	 * The database column name where the model's unique id is stored in.
	 *
	 * @var string
	 */
	protected $uidKeyName = 'uid';
	/**
	 * The database column name where the model's parent id is stored in.
	 * Keep this empty if the model does not have a parent.
	 *
	 * @var string
	 */
	protected $pidKeyName = 'pid';
	/**
	 * The database column name where the model's creation timestamp is stored in.
	 *
	 * @var string
	 */
	protected $createdAtKeyName = 'crdate';
	/**
	 * The database column name where the model's updated timestamp is stored in.
	 *
	 * @var string
	 */
	protected $updatedAtKeyName = 'tstamp';
	/**
	 * The database column name where the model's language information is stored in.
	 * Keep this empty if the model does not have any language information.
	 *
	 * @var string
	 */
	protected $languageKeyName = 'sys_language_uid';
	/**
	 * The database column name where the model's soft deleted information is stored in.
	 * Keep this empty if the model does not have a soft deleted flag.
	 *
	 * @var string
	 */
	protected $softDeletedKeyName = 'deleted';
	/**
	 * Collection of property names which can be written to the database.
	 * The following attributes must not be set:
	 *  - uid
	 *  - pid
	 *  - crdate
	 *  - tstamp.
	 *
	 * @var array
	 */
	protected $fillable = [];
	/**
	 * Optional type cast for all attributes.
	 *
	 * @var array
	 */
	protected $casts = [];
	/**
	 * Collection of all attributes.
	 *
	 * @var array
	 */
	protected $attributes = [];
	/**
	 * Database connection pool.
	 *
	 * @var ConnectionPool
	 */
	protected $connectionPool;
	/**
	 * @var FileRepository
	 */
	protected $fileRepository;


	/**
	 * Model constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		// initialize / clear model properties
		$this->attributes = [];

		if (!\is_array($this->casts)) {
			$this->casts = [];
		}

		if (!\is_array($this->fillable)) {
			$this->fillable = [];
		}
	}

	/**
	 * Inject the connection pool.
	 *
	 * @param \TYPO3\CMS\Core\Database\ConnectionPool $connectionPool
	 */
	public function injectConnectionPool(ConnectionPool $connectionPool)
	{
		$this->connectionPool = $connectionPool;
	}

	/**
	 * Inject the file repository.
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileRepository $fileRepository
	 */
	public function injectFileRepository(FileRepository $fileRepository)
	{
		$this->fileRepository = $fileRepository;
	}

	/**
	 * Magic getter for all model attributes.
	 *
	 * @param string $key Attribute key name
	 *
	 * @return mixed|string
	 */
	public function __get(string $key)
	{
		return $this->cast($key, $this->__isset($key) ? $this->attributes[$key] : '');
	}

	/**
	 * Magic setter for all model attributes.
	 *
	 * @param string                 $key   Attribute key name
	 * @param array|float|int|string $value Value being type casted
	 */
	public function __set(string $key, $value)
	{
		$this->attributes[$key] = $this->cast($key, $value);
	}

	/**
	 * Magic checker if the attribute key name already exists.
	 *
	 * @param string $key Attribute key name
	 *
	 * @return bool
	 */
	public function __isset($key)
	{
		return \array_key_exists($key, $this->attributes);
	}

	/**
	 * Fills all attributes.
	 *
	 * @param array $attributes
	 *
	 * @return $this
	 */
	public function fill(array $attributes): self
	{
		$this->attributes = $attributes;

		return $this;
	}

	/**
	 * Returns a clone of this model.
	 *
	 * @return $this
	 */
	public function clone(): self
	{
		// initialize a new model
		$clone = clone $this;

		$clone->fill($this->attributes);

		return $clone;
	}

	/**
	 * Clears all attributes of this model.
	 *
	 * @return $this
	 */
	public function fresh(): self
	{
		return $this->fill([]);
	}

	/**
	 * Returns the unique key of this model.
	 *
	 * @return int
	 */
	public function getKey(): int
	{
		return (int)$this->__get($this->getKeyColumnName());
	}

	/**
	 * Returns the parent key of this model.
	 *
	 * @return int
	 */
	public function getParentKey(): int
	{
		return (int)$this->__get($this->getParentColumnName());
	}

	/**
	 * Returns the language id of this model.
	 *
	 * @return int
	 */
	public function getLanguageId(): int
	{
		return (int)$this->__get($this->getLanguageColumnName());
	}

	/**
	 * Returns a collection of all model properties.
	 *
	 * @return array
	 */
	public function toArray(): array
	{
		return $this->attributes;
	}

	/**
	 * Checks if the model is already stored in the database and has an unique key.
	 *
	 * @return bool
	 */
	public function exists(): bool
	{
		return $this->getKey() > 0;
	}

	/**
	 * Returns a query builder for this model's table.
	 *
	 * @return QueryBuilder
	 */
	public function query(): QueryBuilder
	{
		return $this->connectionPool->getQueryBuilderForTable($this->getTableName());
	}

	/**
	 * Returns the connection pool instance.
	 *
	 * @return ConnectionPool
	 */
	public function connectionPool(): ConnectionPool
	{
		return $this->connectionPool;
	}

	/**
	 * Returns the database connection for this model's table.
	 *
	 * @return Connection
	 */
	public function getConnection(): Connection
	{
		return $this->connectionPool->getConnectionForTable($this->getTableName());
	}

	/**
	 * Returns the table name of this model.
	 *
	 * @return string
	 */
	public function getTableName(): string
	{
		return $this->table;
	}

	/**
	 * Returns the column name where the unique id is stored in.
	 *
	 * @return string
	 */
	public function getKeyColumnName(): string
	{
		return $this->uidKeyName;
	}

	/**
	 * Returns the column name where the parent id is stored in.
	 *
	 * @return string
	 */
	public function getParentColumnName(): string
	{
		return $this->pidKeyName;
	}

	/**
	 * Returns the column name where the language information is stored in.
	 *
	 * @return string
	 */
	public function getLanguageColumnName(): string
	{
		return $this->languageKeyName;
	}

	/**
	 * Returns any attribute of this model.
	 *
	 * @param string $key attribute key name
	 *
	 * @return mixed
	 */
	public function getAttribute(string $key)
	{
		return $this->__get($key);
	}

	/**
	 * Stores any attribute to this model.
	 *
	 * @param string $key   attribute key name
	 * @param mixed  $value attribute vale
	 */
	public function setAttribute(string $key, $value): void
	{
		$this->__set($key, $value);
	}

	/**
	 * Returns a status flag if this model has a specified attribute or not.
	 *
	 * @param string $key attribute key name
	 *
	 * @return bool
	 */
	public function hasAttribute(string $key): bool
	{
		return $this->__isset($key);
	}

	/**
	 * Stores this model in the database.
	 *
	 * @return bool
	 */
	public function store(): bool
	{
		// extract all fillable attributes of this model
		$fillables = $this->getFillables();

		// check if there are some fillable data
		if (!\count($fillables)) {
			return false;
		}

		// refresh the timestamp when the model was updated the last time ( = now)
		if ('' !== $this->updatedAtKeyName) {
			$this->__set($this->updatedAtKeyName, \time());
			$fillables[$this->updatedAtKeyName] = $this->{$this->updatedAtKeyName};
		}

		// check if the model already exists
		if ($this->exists()) {
			// update the existing model
			return 1 === $this->getConnection()->update($this->getTableName(), $fillables, [$this->getKeyColumnName() => $this->getKey()]);
		}

		// set the creation timestamp of this model
		if ('' !== $this->createdAtKeyName) {
			$this->__set($this->createdAtKeyName, \time());
			$fillables[$this->createdAtKeyName] = $this->{$this->createdAtKeyName};
		}

		// insert the database row and return its status
		return 1 === $this->getConnection()->insert($this->getTableName(), $fillables);
	}

	/**
	 * Deletes the existing database model.
	 *
	 * @param bool $hardDelete optional flag to either hard or soft delete this model (default false = soft deletion)
	 *
	 * @return bool
	 */
	public function delete(bool $hardDelete = false): bool
	{
		return $hardDelete ? $this->hardDelete() : $this->softDelete();
	}

	/**
	 * Soft deletes this model (flag) or hard deletes it if no soft-deletion flag exists for this model type.
	 *
	 * @return bool
	 */
	public function softDelete(): bool
	{
		// check if the model has a soft deletion flag
		if ('' === $this->softDeletedKeyName) {
			// call the hard delete function as this model does not have a soft-deletion flag
			return $this->hardDelete();
		}

		// check if the model already exists
		if (!$this->exists()) {
			// model not found
			return false;
		}

		// set the soft deletion flag
		$this->__set($this->softDeletedKeyName, 1);
		$update = [$this->softDeletedKeyName => 1];

		// soft deletes this model
		return 1 === $this->getConnection()->update($this->getTableName(), $update, [$this->getKeyColumnName() => $this->getKey()]);
	}

	/**
	 * Deletes the existing database model (there is no rollback!).
	 *
	 * @return bool
	 */
	public function hardDelete(): bool
	{
		// check if the model already exists
		if (!$this->exists()) {
			// model not found
			return false;
		}

		// hard deletes the existing model
		return 1 === $this->getConnection()->delete($this->getTableName(), [$this->getKeyColumnName() => $this->getKey()]);
	}

	/**
	 * Fetches a single model by its unique key.
	 *
	 * @param int $key The unique id to load a single model
	 *
	 * @return static
	 */
	public function load(int $key)
	{
		return $this->loadBy($this->getKeyColumnName(), $key);
	}

	/**
	 * Fetches a single model by its unique key-value pair.
	 *
	 * @param string           $columnName The column name
	 * @param string|int|float $value      The unique value to load a single model
	 *
	 * @return static
	 */
	public function loadBy(string $columnName, $value)
	{
		$query = $this->query();

		// fetch all rows which matches the specified column / key combination
		$rows = $query
			->select('*')
			->from($this->getTableName())
			->where(
				$query->expr()->eq($columnName, \is_int($value) ? (int)$value : $query->quote($value))
			)
			->execute()
			->fetchAll();

		// fetch all attributes and update the model
		return $this->fill(1 === \count($rows) ? \array_values($rows)[0] : []);
	}

	/**
	 * Fetches all database rows which matches the specified AND WHERE key-value-pairs and returns them as collection
	 * of this model.
	 *
	 * @param array  $andWhere  collection of key-value-pairs to query the table
	 * @param string $sortBy    optional column name to sort the result
	 * @param string $sortOrder optional sort order (either ASC or DESC, default ASC)
	 *
	 * @return array
	 */
	public static function getCollection(array $andWhere = [], string $sortBy = '', string $sortOrder = 'ASC'): array
	{
		// fetch all rows of this model which matches the combined AND where clauses
		$dummyModel = new static();
		$query = $dummyModel->query();
		$query->select('*');
		$query->from($dummyModel->getTableName());

		// append each key-value-pair
		foreach ($andWhere as $columnName => $value) {
			if (\is_array($value)) {
				// value has a real value and custom operator
				$realValue = $value[0];
				$operator = $value[1];
			} else {
				// simple value, so we use the equal operator
				$realValue = $value;
				$operator = 'eq';
			}

			$query->andWhere(
				$dummyModel->query()->expr()->$operator($columnName, \is_numeric($realValue) ? $realValue : $query->quote($realValue))
			);
		}

		// optionally sort the result
		if ('' !== \trim($sortBy)) {
			$query->orderBy(\trim($sortBy), \trim($sortOrder));
		}

		// convert each row into a model
		$collection = \array_map(function(array $row) use ($dummyModel) {
			return $dummyModel->clone()->fresh()->fill($row);
		}, $query->execute()->fetchAll());

		return $collection;
	}

	/**
	 * Returns all models of this class.
	 *
	 * @return array
	 */
	public static function all(): array
	{
		return self::getCollection();
	}

	/**
	 * Returns all fillable attributes and their values.
	 *
	 * @return array
	 */
	protected function getFillables(): array
	{
		// return all attributes if the model does not have any fillable property
		if (!\count($this->fillable)) {
			return $this->attributes;
		}

		$fillables = [];
		// iterate through all fillables and append it to the collection
		foreach ($this->fillable as $fillableKey) {
			$fillables[$fillableKey] = $this->__get($fillableKey);
		}

		// append the unique id if set
		if ('' !== $this->getKeyColumnName()) {
			$fillables[$this->getKeyColumnName()] = $this->getKey();
		}

		// append the parent id if set
		if ('' !== $this->getParentColumnName()) {
			$fillables[$this->getParentColumnName()] = $this->getParentKey();
		}

		// append the creation timestamp
		if ('' !== $this->createdAtKeyName) {
			$fillables[$this->createdAtKeyName] = $this->__get($this->createdAtKeyName);
		}

		// append the last updated timestamp
		if ('' !== $this->updatedAtKeyName) {
			$fillables[$this->updatedAtKeyName] = $this->__get($this->updatedAtKeyName);
		}

		return $fillables;
	}

	/**
	 * Type casts the specified value according to the defined type.
	 *
	 * @param string                 $key   Attribute key name
	 * @param array|float|int|string $value Value being type casted
	 *
	 * @return array|float|int|string
	 */
	protected function cast(string $key, $value)
	{
		// check if the key has a special type cast method
		if (\method_exists($this, 'cast' . $key)) {
			return $this->{'cast' . $key}($value);
		}

		// get the type cast definition for this attribute key
		$type = \array_key_exists($key, $this->casts) ? $this->casts[$key] : '';
		switch ($type) {
			case 'int':
			case 'integer':
				return (int)$value;
			case 'double':
			case 'float':
			case 'numeric':
			case 'decimal':
				return (float)$value;
			case 'array':
			case 'collection':
			case 'list':
				return (array)$value;
			case 'string':
				return (string)$value;
			default:
				return $value;
		}
	}

	/**
	 * Resolves all files associated to the specified model.
	 *
	 * @param string $table  model's table name as foreign reference
	 * @param string $column file's field name
	 * @param array  $data   array representation of the model
	 *
	 * @return array
	 */
	protected function resolveFiles(string $table, string $column, array $data): array
	{
		$files = $this->fileRepository->findByRelation($table, $column, $data['_LOCALIZED_UID'] ?? $data['uid']);

		return \is_array($files) ? $files : [];
	}

	/**
	 * Resolves a single file associated to the specified model.
	 *
	 * @param string $table  model's table name as foreign reference
	 * @param string $column file's field name
	 * @param array  $data   array representation of the model
	 *
	 * @return \TYPO3\CMS\Core\Resource\FileReference|null
	 */
	protected function resolveFile(string $table, string $column, array $data)
	{
		$files = $this->resolveFiles($table, $column, $data);

		return \is_array($files) ? $files[0] : null;
	}
}
