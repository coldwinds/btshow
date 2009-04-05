<?php
// application/model/GuestBook.php

/**
 * This model class represents the business logic associated with a "guestbook"
 * model.  While its easy to say that models are generally derived from
 * database tables, this is not always the case.  Data sources for models are
 * commonly web services, the filesystem, caching systems, and more.  That
 * said, for the purposes of this guestbook applicaiton, we have split the
 * buisness logic from its datasource (the dbTable).
 *
 * This particular class follows the Table Module pattern.  There are other
 * patterns you might want to employ when modeling for your application, but
 * for the purposes of this example application, this is the best choice.
 * To understand different Modeling Paradigms:
 *
 * @see http://martinfowler.com/eaaCatalog/tableModule.html [Table Module]
 * @see http://martinfowler.com/eaaCatalog/ [See Domain Logic Patterns and Data Source Arch. Patterns]
 */
class Model_Topics
{
	protected  $_db;

	/**
	 *
	 * @return Zend_Db_Adapter_Abstract
	 */
	public function getDB()
	{
		if (null === $this->_db) {
			$this->_db = Zend_Registry::getInstance()->dbAdapter;
		}
		return $this->_db;
	}

	/**
	 * Save a new entry
	 *
	 * @param  array $data
	 * @return int|string
	 */
	public function save(array $data)
	{
		$table  = $this->getTable();
		$fields = $table->info(Zend_Db_Table_Abstract::COLS);
		foreach ($data as $field => $value) {
			if (!in_array($field, $fields)) {
				unset($data[$field]);
			}
		}
		return $table->insert($data);
	}

	/**
	 * Fetch all entries
	 *
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function pageEntries($page,$numPerPage)
	{
		$where = '';

		$sqlcount = 'SELECT count(*) from btm_bt_data b';

		$sql = 'SELECT b.*, s.sort_name ,f.leechers,f.seeders,f.completed,t.team_name
 FROM btm_bt_data b
 left join btm_sort s on b.sort_id = s.sort_id
 left join xbt_files f on b.info_hash = f.info_hash
 left join btm_team t on b.team_id = t.team_id ';
			
		$order = ' order by release_date desc ';
		$limit = ' LIMIT '.($page-1)*$numPerPage.','.$numPerPage.' ';

		$count = $this->getDB()->fetchRow($sqlcount.$where);

		$data = $this->getDB()->fetchAll($sql.$where.$order.$limit);

		return array('count' => $count,'data'=> $data);
	}


	/**
	 * Fetch an individual entry
	 *
	 * @param  int|string $id
	 * @return null|Zend_Db_Table_Row_Abstract
	 */
	public function fetchEntry($id)
	{
		$table = $this->getTable();
		$select = $table->select()->where('id = ?', $id);
		// see reasoning in fetchEntries() as to why we return only an array
		return $table->fetchRow($select)->toArray();
	}
}
