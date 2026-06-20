<?php declare(strict_types = 1);

// osfsl-D:/HTML/Guia_PHP_Practivca_2/test/vendor/composer/../laravel/framework/src/Illuminate/Session/EncryptedStore.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Illuminate\Session\EncryptedStore
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-75cd78daff05208413fe4d6fc7a678888010181dc44226e908c777966663a6fa-8.3.30-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Illuminate\\Session\\EncryptedStore',
        'filename' => 'D:/HTML/Guia_PHP_Practivca_2/test/vendor/composer/../laravel/framework/src/Illuminate/Session/EncryptedStore.php',
      ),
    ),
    'namespace' => 'Illuminate\\Session',
    'name' => 'Illuminate\\Session\\EncryptedStore',
    'shortName' => 'EncryptedStore',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => NULL,
    'attributes' => 
    array (
    ),
    'startLine' => 9,
    'endLine' => 69,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Illuminate\\Session\\Store',
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
      'encrypter' => 
      array (
        'declaringClassName' => 'Illuminate\\Session\\EncryptedStore',
        'implementingClassName' => 'Illuminate\\Session\\EncryptedStore',
        'name' => 'encrypter',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The encrypter instance.
 *
 * @var \\Illuminate\\Contracts\\Encryption\\Encrypter
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 16,
        'endLine' => 16,
        'startColumn' => 5,
        'endColumn' => 25,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
    ),
    'immediateMethods' => 
    array (
      '__construct' => 
      array (
        'name' => '__construct',
        'parameters' => 
        array (
          'name' => 
          array (
            'name' => 'name',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 27,
            'endLine' => 27,
            'startColumn' => 33,
            'endColumn' => 37,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'handler' => 
          array (
            'name' => 'handler',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'SessionHandlerInterface',
                'isIdentifier' => false,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 27,
            'endLine' => 27,
            'startColumn' => 40,
            'endColumn' => 71,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
          'encrypter' => 
          array (
            'name' => 'encrypter',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'Illuminate\\Contracts\\Encryption\\Encrypter',
                'isIdentifier' => false,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 27,
            'endLine' => 27,
            'startColumn' => 74,
            'endColumn' => 101,
            'parameterIndex' => 2,
            'isOptional' => false,
          ),
          'id' => 
          array (
            'name' => 'id',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 27,
                'endLine' => 27,
                'startTokenPos' => 68,
                'startFilePos' => 752,
                'endTokenPos' => 68,
                'endFilePos' => 755,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 27,
            'endLine' => 27,
            'startColumn' => 104,
            'endColumn' => 113,
            'parameterIndex' => 3,
            'isOptional' => true,
          ),
          'serialization' => 
          array (
            'name' => 'serialization',
            'default' => 
            array (
              'code' => '\'php\'',
              'attributes' => 
              array (
                'startLine' => 27,
                'endLine' => 27,
                'startTokenPos' => 75,
                'startFilePos' => 775,
                'endTokenPos' => 75,
                'endFilePos' => 779,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 27,
            'endLine' => 27,
            'startColumn' => 116,
            'endColumn' => 137,
            'parameterIndex' => 4,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Create a new session instance.
 *
 * @param  string  $name
 * @param  \\SessionHandlerInterface  $handler
 * @param  \\Illuminate\\Contracts\\Encryption\\Encrypter  $encrypter
 * @param  string|null  $id
 * @param  string  $serialization
 */',
        'startLine' => 27,
        'endLine' => 32,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Session',
        'declaringClassName' => 'Illuminate\\Session\\EncryptedStore',
        'implementingClassName' => 'Illuminate\\Session\\EncryptedStore',
        'currentClassName' => 'Illuminate\\Session\\EncryptedStore',
        'aliasName' => NULL,
      ),
      'prepareForUnserialize' => 
      array (
        'name' => 'prepareForUnserialize',
        'parameters' => 
        array (
          'data' => 
          array (
            'name' => 'data',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 40,
            'endLine' => 40,
            'startColumn' => 46,
            'endColumn' => 50,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Prepare the raw string data from the session for unserialization.
 *
 * @param  string  $data
 * @return string
 */',
        'startLine' => 40,
        'endLine' => 47,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Session',
        'declaringClassName' => 'Illuminate\\Session\\EncryptedStore',
        'implementingClassName' => 'Illuminate\\Session\\EncryptedStore',
        'currentClassName' => 'Illuminate\\Session\\EncryptedStore',
        'aliasName' => NULL,
      ),
      'prepareForStorage' => 
      array (
        'name' => 'prepareForStorage',
        'parameters' => 
        array (
          'data' => 
          array (
            'name' => 'data',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 55,
            'endLine' => 55,
            'startColumn' => 42,
            'endColumn' => 46,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Prepare the serialized session data for storage.
 *
 * @param  string  $data
 * @return string
 */',
        'startLine' => 55,
        'endLine' => 58,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Session',
        'declaringClassName' => 'Illuminate\\Session\\EncryptedStore',
        'implementingClassName' => 'Illuminate\\Session\\EncryptedStore',
        'currentClassName' => 'Illuminate\\Session\\EncryptedStore',
        'aliasName' => NULL,
      ),
      'getEncrypter' => 
      array (
        'name' => 'getEncrypter',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the encrypter instance.
 *
 * @return \\Illuminate\\Contracts\\Encryption\\Encrypter
 */',
        'startLine' => 65,
        'endLine' => 68,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Session',
        'declaringClassName' => 'Illuminate\\Session\\EncryptedStore',
        'implementingClassName' => 'Illuminate\\Session\\EncryptedStore',
        'currentClassName' => 'Illuminate\\Session\\EncryptedStore',
        'aliasName' => NULL,
      ),
    ),
    'traitsData' => 
    array (
      'aliases' => 
      array (
      ),
      'modifiers' => 
      array (
      ),
      'precedences' => 
      array (
      ),
      'hashes' => 
      array (
      ),
    ),
  ),
));