<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/helpers/Tooling.php";


$app = new Leaf\App;

$app->post("/exo-1", function() use($app) {

  $firstname = $app->request()->get('firstname');
  $lastname = $app->request()->get('lastname');
  $age = (int) $app->request()->get('age');
  $github = $app->request()->get('github');

  // On va push dans ce tableau tous les champs qui ne sont pas validés
  $errors = [];

  if(!$firstname || strlen($firstname) < 3 || strlen($firstname) > 30) {
    $errors['firstname'] = 'firstname is not valid';
  }

  if(!$lastname || strlen($lastname) < 3 || strlen($lastname) > 50) {
    $errors['lastname'] = 'lastname is not valid';
  }

  if(!$age || $age < 18 || $age > 120) {
    $errors['age'] = 'age is not valid';
  }

  if($github)
  {
    if(!filter_var($github, FILTER_VALIDATE_URL)){
      $errors['github'] = 'github url is invalid';
    }
  }

  if(count($errors) > 0) return $app->response->throwErr($errors, 400);

  return $app->response->json($app->request->body());

});

$app->post("/exo-2", function() use($app) {

  $phone = $app->request()->get('phone');
  $description = $app->request()->get('description');
  $type = $app->request()->get('type');

  // On va push dans ce tableau tous les champs qui ne sont pas validés
  $errors = [];

  if(!$description || strlen($description) < 3 || strlen($description) > 250) {
    $errors['description'] = 'description is not valid';
  }

  $phoneRegex = "/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/";

  if(!$phone || !preg_match($phoneRegex, $phone)) {
    $errors['phone'] = 'phone is not valid';
  }

  if(!$type || $type !== "contact") {
    $errors['type'] = 'type is not valid';
  }

  if(count($errors) > 0) return $app->response->throwErr($errors, 400);

  return $app->response->json([
    'phone' => $phone,
    'description' => trim($description),
    'type' => $type,
  ]);

});


$app->post("/exo-3", function() use($app) {

  $email = $app->request()->get('email');
  $password = $app->request()->get('password');
  $password_confirmation = $app->request()->get('password_confirmation');
  $birthdate = $app->request()->get('birthdate');

  // On va push dans ce tableau tous les champs qui ne sont pas validés
  $errors = [];

  if(!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'email is not valid';
  }

  $passwordRegex = "/^(?:(?=.*[a-z])(?:(?=.*[A-Z])(?=.*[\d\W])|(?=.*\W)(?=.*\d))|(?=.*\W)(?=.*[A-Z])(?=.*\d)).{8,}$/";

  if(!$password || !preg_match($passwordRegex, $password)) {
    $errors['password'] = 'password is not valid';
  }

  if(!$password_confirmation || $password_confirmation !== $password) {
    $errors['password_confirmation '] = 'password_confirmation is not valid';
  }

  $birthdateRegex = "/^(((0[1-9])|(1\d)|(2\d)|(3[0-1]))\/((0[1-9])|(1[0-2]))\/(\d{4}))$/";

  if(!$birthdate || !preg_match($birthdateRegex, $birthdate)) {
    $errors['birthdate'] = 'birthdate is not valid';
  }

  if(count($errors) > 0) return $app->response->throwErr($errors, 400);

  return $app->response->json([
    'email' => $email,
    'birthdate' => $birthdate,
  ]);

});


$app->run();
