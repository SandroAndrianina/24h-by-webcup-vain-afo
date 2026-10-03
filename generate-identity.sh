#!/bin/bash

BASE="app/Modules/Identity"

# Créer les dossiers
mkdir -p $BASE/Domain/Entities
mkdir -p $BASE/Domain/ValueObjects
mkdir -p $BASE/Domain/Repositories
mkdir -p $BASE/Application/DTOs
mkdir -p $BASE/Infrastructure
mkdir -p $BASE/Http/Controllers

# Créer les fichiers vides
touch $BASE/Domain/Entities/User.php
touch $BASE/Domain/ValueObjects/Email.php
touch $BASE/Domain/ValueObjects/Role.php
touch $BASE/Domain/Repositories/UserRepositoryInterface.php
touch $BASE/Application/RegisterUser.php
touch $BASE/Application/LoginUser.php
touch $BASE/Application/DTOs/RegisterUserDTO.php
touch $BASE/Infrastructure/UserModel.php
touch $BASE/Infrastructure/UserRepository.php
touch $BASE/Http/Controllers/AuthController.php
touch $BASE/Http/Routes.php

echo "✅ Module Identity généré."
tree $BASE 2>/dev/null || find $BASE -type f