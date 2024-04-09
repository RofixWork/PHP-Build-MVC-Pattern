<?php
namespace App\DI;

use App\EntryNotFoundException;

include __DIR__ . '/../../vendor/autoload.php';

$container = new Container();

//$container->set(EmailService::class, fn() => new EmailService());
//$container->set(DatabaseService::class, fn() => new DatabaseService());
//
$container->set(UserService::class, fn() : UserService => new UserService($container->get(EmailService::class), $container->get(DatabaseService::class)));
/**
 * @var UserService $user
 */
$user = $container->get(UserService::class);
var_dump($user);
//$user->register();
//
//$container->getEntries();

//class A {
//
//}
//class Test
//{
//    public function __construct(private string $name, private int $age, private A $a)
//    {
//    }
//
//    public function getName() : string
//    {
//        return $this->name;
//    }
//}
//
//$reflection = new \ReflectionClass(Test::class);
//$constructor = $reflection->getConstructor();
//$params = $constructor->getParameters();
//
//$arr = array_map(function(\ReflectionParameter $parameter) {
//    $type = $parameter->getType();
//    var_dump($type instanceof \ReflectionNamedType );
//}, $params);


