# 📚 BOOKLY - Plateforme eCommerce de Librairie

## 🎯 Objectif Global
Développer une plateforme eCommerce complète de vente de livres avec :
- Une partie **vitrine (FrontOffice)** destinée aux clients
- Une partie **administration (BackOffice)** pour les gestionnaires

---

## 📋 Caractéristiques Principales

### 1. Type de Projet
- **Framework** : Symfony 7.3  
- **Type** : Application Web MVC (Model-View-Controller)  
- **Base de données** : Doctrine ORM avec MySQL/MariaDB  
- **Architecture** : Monolithique  

### 2. Modules Principaux
#### FrontOffice (Clients)
- Page d'accueil avec catalogue de livres  
- Recherche avancée par titre et auteur  
- Catalogue complet avec filtrage par catégories  
- Panier d'achat avec gestion des quantités  
- Liste de souhaits (Wishlist)  
- Profil utilisateur modifiable  
- Authentification et inscription  

#### BackOffice (Gestionnaires)
- Tableau de bord avec statistiques  
- Gestion CRUD complète :  
  - **Livres** : Ajout, modification, suppression, upload d’images  
  - **Catégories** : Gestion des catégories de livres  
  - **Auteurs** : Gestion des auteurs  
  - **Éditeurs** : Gestion des éditeurs  
  - **Utilisateurs** : Gestion des comptes clients  
  - **Ouvriers** : Gestion du personnel (si applicable)  

---

## 🗄️ Structure de la Base de Données
6 entités principales :
- **Livre** : titre, ISBN, prix, quantité, description, image  
- **Categorie** : classification des livres avec images  
- **Auteur** : nom, prénom  
- **Editeur** : nom, pays, adresse, téléphone  
- **User** : comptes utilisateurs avec rôles et authentification  
- **Ouvrier** : nom, prénom, salaire, date de naissance  

---

## 🔐 Sécurité et Authentification
- **Rôles utilisateurs** :  
  - `ROLE_USER` : Utilisateurs enregistrés  
  - `ROLE_ADMIN` : Administrateurs avec accès complet  
- **Authentification** : Formulaire de connexion avec hash de mot de passe  
- **Protection des routes** :  
  - `/admin` → réservé aux `ROLE_ADMIN`  
  - `/profile` → réservé aux `ROLE_USER`  
  - `/login`, `/register` → publiques  

---

## 🎨 Interface et Design
- **Thème** : "Bookly" - Bootstrap 5 Template adapté et personnalisé  
- **CSS personnalisé** : 1353 lignes de styles custom  
- **Composants** :  
  - Swiper.js pour carrousels  
  - Google Fonts (Nunito)  
  - Design responsive  
  - Badges et compteurs dynamiques pour panier/wishlist  

---

## 🛠️ Technologies et Dépendances
- **Framework** : Symfony 7.3  
- **Base de données** : Doctrine ORM v3.5  
- **Admin** : EasyAdmin Bundle v4.27  
- **ORM** : Doctrine Migrations pour versioning BD  
- **Frontend** : Twig, Bootstrap 5, Swiper.js  
- **Services** : Mailer, Notifier, Messenger, Validator  
- **Sécurité** : Security Bundle avec CSRF protection  

---

## 📦 Fonctionnalités Principales
- ✅ Catalogue de livres dynamique  
- ✅ Recherche multicanal (titre, auteur)  
- ✅ Panier persistant avec calcul de total  
- ✅ Wishlist / Liste de souhaits  
- ✅ Gestion de compte utilisateur  
- ✅ Panel d'administration complet  
- ✅ Système de catégories et filtrage  
- ✅ Upload d'images pour livres et catégories  
- ✅ Authentification sécurisée  
- ✅ Gestion de rôles et permissions  

---

## 🎓 Nature du Projet
Projet pédagogique complet démontrant :
- L’architecture MVC avec Symfony  
- Les relations Doctrine (Many-to-Many, Many-to-One)  
- Les Repository patterns  
- L’authentification et l’autorisation  
- EasyAdmin pour les CRUD  
- La gestion des assets et du design responsif  
- Les services personnalisés (Cart, Wishlist)  

---

## ✨ Résumé
**Bookly** est une plateforme eCommerce de vente de livres complète construite avec **Symfony 7.3**, combinant :  
- Une vitrine client attractive  
- Une administration robuste pour la gestion des produits et utilisateurs  
