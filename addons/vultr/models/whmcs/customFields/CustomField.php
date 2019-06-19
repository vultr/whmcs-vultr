<?php
namespace MGModule\vultr\models\whmcs\customFields;
use MGModule\vultr as main;

/**
 * Product Custom Fields depends on WHMCS
 *
 * @Table(name=tblcustomfields,preventUpdate,prefixed=false)
 */
class CustomField extends \MGModule\vultr\mgLibs\models\Orm
{
	/**
	 * @Column()
	 * @var int
	 */
	public $id;

	/**
	 * @var string
	 */
	public $parentType;

	/**
	 * @var int
	 */
	public $parentId;

	/**
	 * @var int
	 */
	public $definition;


	/**
	 * @Column(name=fieldname,as=fieldnameFull)
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $friendlyName;

	/**
	 * @Column()
	 * @var string
	 */
	public $fieldtype = 'text';

	/**
	 * @Column()
	 * @var string
	 */
	public $description = '';

	/**
	 * @Column(as=fieldoptionsEncoded)
	 * @var array
	 */
	public $fieldoptions = array();

	/**
	 * @Column()
	 * @var string
	 */
	public $regexpr = '';

	/**
	 * @Column()
	 * @var boolean
	 */
	public $adminonly = 'on';

	/**
	 * @Column()
	 * @var boolean
	 */
	public $required = '';

	/**
	 * @Column()
	 * @var boolean
	 */
	public $showorder = '';

	/**
	 * @Column()
	 * @var boolean
	 */
	public $showinvoice = '';

	/**
	 * @Column()
	 * @var boolean
	 */
	public $sortorder = 0;

	/**
	 * Load Custom Field
	 *
	 * @param int $productID
	 * @param int $id
	 * @param array $data
	 */
	function __construct($id = null, $parentType = null, $parentID = null, $data = array())
	{
		$this->id = $id;
		$this->parentType = $parentType;
		$this->parentId = $parentID;

		if ($this->id && empty($data))
		{
			$conditions = array(
				'id'     => $this->id,
				'reldid' => $this->parentId,
				'type'   => $this->parentType
			);

			$data = main\mgLibs\MySQL\Query::select(self::$fieldDeclaration, self::tableName(), $conditions)->fetch();
			if (empty($data))
			{
				throw new main\mgLibs\exceptions\System('Unable to find custom field:' . http_build_query($conditions));
			}
		}

		if (!empty($data))
		{
			if (!empty($data['fieldnameFull']))
			{
				$tmp = explode('|', $data['fieldnameFull']);
				$data['name'] = $data['fieldnameFull'] = $tmp[0];
				if (!empty($tmp[1]))
				{
					$data['friendlyName'] = $tmp[1];
				}
			}

			if (isset($data['fieldoptionsEncoded']))
			{
				$data['fieldoptions'] = array_filter(explode(',', $data['fieldoptionsEncoded']));
			}

			$this->fillProperties($data);
		}
	}

	/**
	 * Save Field
	 */
	function save()
	{
		$data = array(
			'type' => $this->parentType,
			'relid' => $this->productID,
			'fieldtype' => $this->fieldtype,
			'description' => $this->description,
			'fieldoptions' => implode(',', $this->fieldoptions),
			'regexpr' => $this->regexpr,
			'adminonly' => $this->adminonly,
			'required' => $this->required,
			'showorder' => $this->showorder,
			'showinvoice' => $this->showinvoice,
			'sortorder' => $this->sortorder
		);

		if (empty($this->friendlyName))
		{
			$data['fieldname'] = $this->name;
		}
		else
		{
			$data['fieldname'] = $this->name . '|' . $this->friendlyName;
		}

		if ($this->id)
		{
			main\mgLibs\MySQL\Query::update(self::tableName(), $data, array('id' => $this->id));
		}
		else
		{
			$this->id = main\mgLibs\MySQL\Query::insert(self::tableName(), $data);
		}
	}
}
