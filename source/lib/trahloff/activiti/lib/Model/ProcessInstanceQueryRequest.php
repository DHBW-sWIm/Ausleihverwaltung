<?php
/**
 * ProcessInstanceQueryRequest
 *
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * sWIm Activiti REST API
 *
 * here be dragons
 *
 * OpenAPI spec version: v0.2.0
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Model;

use \ArrayAccess;
use \Swagger\Client\ObjectSerializer;

/**
 * ProcessInstanceQueryRequest Class Doc Comment
 *
 * @category Class
 * @package     Swagger\Client
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class ProcessInstanceQueryRequest implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'ProcessInstanceQueryRequest';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'start' => 'int',
        'size' => 'int',
        'sort' => 'string',
        'order' => 'string',
        'process_instance_id' => 'string',
        'process_business_key' => 'string',
        'process_definition_id' => 'string',
        'process_definition_key' => 'string',
        'super_process_instance_id' => 'string',
        'sub_process_instance_id' => 'string',
        'exclude_subprocesses' => 'bool',
        'involved_user' => 'string',
        'suspended' => 'bool',
        'include_process_variables' => 'bool',
        'variables' => '\Swagger\Client\Model\QueryVariable[]',
        'tenant_id' => 'string',
        'tenant_id_like' => 'string',
        'without_tenant_id' => 'bool'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'start' => 'int32',
        'size' => 'int32',
        'sort' => null,
        'order' => null,
        'process_instance_id' => null,
        'process_business_key' => null,
        'process_definition_id' => null,
        'process_definition_key' => null,
        'super_process_instance_id' => null,
        'sub_process_instance_id' => null,
        'exclude_subprocesses' => null,
        'involved_user' => null,
        'suspended' => null,
        'include_process_variables' => null,
        'variables' => null,
        'tenant_id' => null,
        'tenant_id_like' => null,
        'without_tenant_id' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'start' => 'start',
        'size' => 'size',
        'sort' => 'sort',
        'order' => 'order',
        'process_instance_id' => 'processInstanceId',
        'process_business_key' => 'processBusinessKey',
        'process_definition_id' => 'processDefinitionId',
        'process_definition_key' => 'processDefinitionKey',
        'super_process_instance_id' => 'superProcessInstanceId',
        'sub_process_instance_id' => 'subProcessInstanceId',
        'exclude_subprocesses' => 'excludeSubprocesses',
        'involved_user' => 'involvedUser',
        'suspended' => 'suspended',
        'include_process_variables' => 'includeProcessVariables',
        'variables' => 'variables',
        'tenant_id' => 'tenantId',
        'tenant_id_like' => 'tenantIdLike',
        'without_tenant_id' => 'withoutTenantId'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'start' => 'setStart',
        'size' => 'setSize',
        'sort' => 'setSort',
        'order' => 'setOrder',
        'process_instance_id' => 'setProcessInstanceId',
        'process_business_key' => 'setProcessBusinessKey',
        'process_definition_id' => 'setProcessDefinitionId',
        'process_definition_key' => 'setProcessDefinitionKey',
        'super_process_instance_id' => 'setSuperProcessInstanceId',
        'sub_process_instance_id' => 'setSubProcessInstanceId',
        'exclude_subprocesses' => 'setExcludeSubprocesses',
        'involved_user' => 'setInvolvedUser',
        'suspended' => 'setSuspended',
        'include_process_variables' => 'setIncludeProcessVariables',
        'variables' => 'setVariables',
        'tenant_id' => 'setTenantId',
        'tenant_id_like' => 'setTenantIdLike',
        'without_tenant_id' => 'setWithoutTenantId'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'start' => 'getStart',
        'size' => 'getSize',
        'sort' => 'getSort',
        'order' => 'getOrder',
        'process_instance_id' => 'getProcessInstanceId',
        'process_business_key' => 'getProcessBusinessKey',
        'process_definition_id' => 'getProcessDefinitionId',
        'process_definition_key' => 'getProcessDefinitionKey',
        'super_process_instance_id' => 'getSuperProcessInstanceId',
        'sub_process_instance_id' => 'getSubProcessInstanceId',
        'exclude_subprocesses' => 'getExcludeSubprocesses',
        'involved_user' => 'getInvolvedUser',
        'suspended' => 'getSuspended',
        'include_process_variables' => 'getIncludeProcessVariables',
        'variables' => 'getVariables',
        'tenant_id' => 'getTenantId',
        'tenant_id_like' => 'getTenantIdLike',
        'without_tenant_id' => 'getWithoutTenantId'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['start'] = isset($data['start']) ? $data['start'] : null;
        $this->container['size'] = isset($data['size']) ? $data['size'] : null;
        $this->container['sort'] = isset($data['sort']) ? $data['sort'] : null;
        $this->container['order'] = isset($data['order']) ? $data['order'] : null;
        $this->container['process_instance_id'] = isset($data['process_instance_id']) ? $data['process_instance_id'] : null;
        $this->container['process_business_key'] = isset($data['process_business_key']) ? $data['process_business_key'] : null;
        $this->container['process_definition_id'] = isset($data['process_definition_id']) ? $data['process_definition_id'] : null;
        $this->container['process_definition_key'] = isset($data['process_definition_key']) ? $data['process_definition_key'] : null;
        $this->container['super_process_instance_id'] = isset($data['super_process_instance_id']) ? $data['super_process_instance_id'] : null;
        $this->container['sub_process_instance_id'] = isset($data['sub_process_instance_id']) ? $data['sub_process_instance_id'] : null;
        $this->container['exclude_subprocesses'] = isset($data['exclude_subprocesses']) ? $data['exclude_subprocesses'] : false;
        $this->container['involved_user'] = isset($data['involved_user']) ? $data['involved_user'] : null;
        $this->container['suspended'] = isset($data['suspended']) ? $data['suspended'] : false;
        $this->container['include_process_variables'] = isset($data['include_process_variables']) ? $data['include_process_variables'] : false;
        $this->container['variables'] = isset($data['variables']) ? $data['variables'] : null;
        $this->container['tenant_id'] = isset($data['tenant_id']) ? $data['tenant_id'] : null;
        $this->container['tenant_id_like'] = isset($data['tenant_id_like']) ? $data['tenant_id_like'] : null;
        $this->container['without_tenant_id'] = isset($data['without_tenant_id']) ? $data['without_tenant_id'] : false;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {

        return true;
    }


    /**
     * Gets start
     *
     * @return int
     */
    public function getStart()
    {
        return $this->container['start'];
    }

    /**
     * Sets start
     *
     * @param int $start start
     *
     * @return $this
     */
    public function setStart($start)
    {
        $this->container['start'] = $start;

        return $this;
    }

    /**
     * Gets size
     *
     * @return int
     */
    public function getSize()
    {
        return $this->container['size'];
    }

    /**
     * Sets size
     *
     * @param int $size size
     *
     * @return $this
     */
    public function setSize($size)
    {
        $this->container['size'] = $size;

        return $this;
    }

    /**
     * Gets sort
     *
     * @return string
     */
    public function getSort()
    {
        return $this->container['sort'];
    }

    /**
     * Sets sort
     *
     * @param string $sort sort
     *
     * @return $this
     */
    public function setSort($sort)
    {
        $this->container['sort'] = $sort;

        return $this;
    }

    /**
     * Gets order
     *
     * @return string
     */
    public function getOrder()
    {
        return $this->container['order'];
    }

    /**
     * Sets order
     *
     * @param string $order order
     *
     * @return $this
     */
    public function setOrder($order)
    {
        $this->container['order'] = $order;

        return $this;
    }

    /**
     * Gets process_instance_id
     *
     * @return string
     */
    public function getProcessInstanceId()
    {
        return $this->container['process_instance_id'];
    }

    /**
     * Sets process_instance_id
     *
     * @param string $process_instance_id process_instance_id
     *
     * @return $this
     */
    public function setProcessInstanceId($process_instance_id)
    {
        $this->container['process_instance_id'] = $process_instance_id;

        return $this;
    }

    /**
     * Gets process_business_key
     *
     * @return string
     */
    public function getProcessBusinessKey()
    {
        return $this->container['process_business_key'];
    }

    /**
     * Sets process_business_key
     *
     * @param string $process_business_key process_business_key
     *
     * @return $this
     */
    public function setProcessBusinessKey($process_business_key)
    {
        $this->container['process_business_key'] = $process_business_key;

        return $this;
    }

    /**
     * Gets process_definition_id
     *
     * @return string
     */
    public function getProcessDefinitionId()
    {
        return $this->container['process_definition_id'];
    }

    /**
     * Sets process_definition_id
     *
     * @param string $process_definition_id process_definition_id
     *
     * @return $this
     */
    public function setProcessDefinitionId($process_definition_id)
    {
        $this->container['process_definition_id'] = $process_definition_id;

        return $this;
    }

    /**
     * Gets process_definition_key
     *
     * @return string
     */
    public function getProcessDefinitionKey()
    {
        return $this->container['process_definition_key'];
    }

    /**
     * Sets process_definition_key
     *
     * @param string $process_definition_key process_definition_key
     *
     * @return $this
     */
    public function setProcessDefinitionKey($process_definition_key)
    {
        $this->container['process_definition_key'] = $process_definition_key;

        return $this;
    }

    /**
     * Gets super_process_instance_id
     *
     * @return string
     */
    public function getSuperProcessInstanceId()
    {
        return $this->container['super_process_instance_id'];
    }

    /**
     * Sets super_process_instance_id
     *
     * @param string $super_process_instance_id super_process_instance_id
     *
     * @return $this
     */
    public function setSuperProcessInstanceId($super_process_instance_id)
    {
        $this->container['super_process_instance_id'] = $super_process_instance_id;

        return $this;
    }

    /**
     * Gets sub_process_instance_id
     *
     * @return string
     */
    public function getSubProcessInstanceId()
    {
        return $this->container['sub_process_instance_id'];
    }

    /**
     * Sets sub_process_instance_id
     *
     * @param string $sub_process_instance_id sub_process_instance_id
     *
     * @return $this
     */
    public function setSubProcessInstanceId($sub_process_instance_id)
    {
        $this->container['sub_process_instance_id'] = $sub_process_instance_id;

        return $this;
    }

    /**
     * Gets exclude_subprocesses
     *
     * @return bool
     */
    public function getExcludeSubprocesses()
    {
        return $this->container['exclude_subprocesses'];
    }

    /**
     * Sets exclude_subprocesses
     *
     * @param bool $exclude_subprocesses exclude_subprocesses
     *
     * @return $this
     */
    public function setExcludeSubprocesses($exclude_subprocesses)
    {
        $this->container['exclude_subprocesses'] = $exclude_subprocesses;

        return $this;
    }

    /**
     * Gets involved_user
     *
     * @return string
     */
    public function getInvolvedUser()
    {
        return $this->container['involved_user'];
    }

    /**
     * Sets involved_user
     *
     * @param string $involved_user involved_user
     *
     * @return $this
     */
    public function setInvolvedUser($involved_user)
    {
        $this->container['involved_user'] = $involved_user;

        return $this;
    }

    /**
     * Gets suspended
     *
     * @return bool
     */
    public function getSuspended()
    {
        return $this->container['suspended'];
    }

    /**
     * Sets suspended
     *
     * @param bool $suspended suspended
     *
     * @return $this
     */
    public function setSuspended($suspended)
    {
        $this->container['suspended'] = $suspended;

        return $this;
    }

    /**
     * Gets include_process_variables
     *
     * @return bool
     */
    public function getIncludeProcessVariables()
    {
        return $this->container['include_process_variables'];
    }

    /**
     * Sets include_process_variables
     *
     * @param bool $include_process_variables include_process_variables
     *
     * @return $this
     */
    public function setIncludeProcessVariables($include_process_variables)
    {
        $this->container['include_process_variables'] = $include_process_variables;

        return $this;
    }

    /**
     * Gets variables
     *
     * @return \Swagger\Client\Model\QueryVariable[]
     */
    public function getVariables()
    {
        return $this->container['variables'];
    }

    /**
     * Sets variables
     *
     * @param \Swagger\Client\Model\QueryVariable[] $variables variables
     *
     * @return $this
     */
    public function setVariables($variables)
    {
        $this->container['variables'] = $variables;

        return $this;
    }

    /**
     * Gets tenant_id
     *
     * @return string
     */
    public function getTenantId()
    {
        return $this->container['tenant_id'];
    }

    /**
     * Sets tenant_id
     *
     * @param string $tenant_id tenant_id
     *
     * @return $this
     */
    public function setTenantId($tenant_id)
    {
        $this->container['tenant_id'] = $tenant_id;

        return $this;
    }

    /**
     * Gets tenant_id_like
     *
     * @return string
     */
    public function getTenantIdLike()
    {
        return $this->container['tenant_id_like'];
    }

    /**
     * Sets tenant_id_like
     *
     * @param string $tenant_id_like tenant_id_like
     *
     * @return $this
     */
    public function setTenantIdLike($tenant_id_like)
    {
        $this->container['tenant_id_like'] = $tenant_id_like;

        return $this;
    }

    /**
     * Gets without_tenant_id
     *
     * @return bool
     */
    public function getWithoutTenantId()
    {
        return $this->container['without_tenant_id'];
    }

    /**
     * Sets without_tenant_id
     *
     * @param bool $without_tenant_id without_tenant_id
     *
     * @return $this
     */
    public function setWithoutTenantId($without_tenant_id)
    {
        $this->container['without_tenant_id'] = $without_tenant_id;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param  integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param  integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param  integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}

