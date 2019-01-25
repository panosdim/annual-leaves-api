# Annual Leaves REST API
It is build with [Laravel](https://laravel.com/) and provide a REST API to store annual leaves per user.

# API Details
* [Register](#register)
* [Login](#login)
* [User Info](#user-info)
* [Update User Info](#update-user-info)
* [Get All Leaves](#get-all-leaves)
* [Get A Specific Leave](#get-a-specific-leave)
* [Create New Leave](#create-new-leave)
* [Update A Leave](#update-a-leave)
* [Delete A Leave](#delete-a-leave)

# Register

Used to registered a new User.

**URL** : `/register`

**Method** : `POST`

**Auth required** : NO

**Data constraints**

```json
{
    "name": "[Full name in plain text]",
    "email": "[valid email address]",
    "password": "[password in plain text]",
    "total_leaves": "[Total Annual Leave Days per year]"
}
```

**Data example**

```json
{
    "name": "Love Examples",
    "email": "iloveauth@example.com",
    "password": "abcd1234",
    "total_leaves": 25
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkubGVhdmVzLmNjLm5mXC9yZWdpc3RlciIsImlhdCI6MTU0ODMzOTUyOSwiZXhwIjoxNTQ4MzQzMTI5LCJuYmYiOjE1NDgzMzk1MjksImp0aSI6IjlneTZxZUJsdnVuVEtXbG4iLCJzdWIiOjIsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.eOqmBnqcnvZglMnhBeAWaKP9KdVqDx6iunewPdTBjvA",
    "token_type": "bearer",
    "expires_in": 3600
}
```

# Login 

Used to collect a Token for a registered User.

**URL** : `/login`

**Method** : `POST`

**Auth required** : NO

**Data constraints**

```json
{
    "email": "[valid email address]",
    "password": "[password in plain text]"
}
```

**Data example**

```json
{
    "email": "iloveauth@example.com",
    "password": "abcd1234"
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkubGVhdmVzLmNjLm5mXC9sb2dpbiIsImlhdCI6MTU0ODMzOTczOCwiZXhwIjoxNTQ4MzQzMzM4LCJuYmYiOjE1NDgzMzk3MzgsImp0aSI6InZvZEJPdU9PT0dHWU1SNFYiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.aK_IBxqkhFBwCE5gFSBHLAnQJLe-tJnZ3dZWCZb4vwE",
    "token_type": "bearer",
    "expires_in": 3600
}
```

## Error Response

**Condition** : If 'username' and 'password' combination is wrong.

**Code** : `401 UNAUTHORIZED`

**Content** :

```json
{
    "error": "Unauthorized"
}
```

# User Info 

Used to collect info for a registered User.

**URL** : `/user`

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "id": 1,
    "name": "Love Examples",
    "email": "iloveauth@example.com",
    "email_verified_at": null,
    "total_leaves": 20,
    "created_at": "2019-01-24 13:02:19",
    "updated_at": "2019-01-24 13:02:19"
}
```

## Error Response

**Condition** : If bearer token is not valid.

**Code** : `500 INTERNAL SERVER ERROR`

# Update User Info

Used to update info for a registered User.

**URL** : `/user/{id}`

**Method** : `PUT`

**Auth required** : YES

**Data constraints**

```json
{
    "name": "[User full name in plain text]",
    "total_leaves": "[Total Annual Leave Days per year]"
}
```

**Data example**

```json
{
    "name": "Love Examples",
    "total_leaves": 25
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "id": 1,
    "name": "Love Examples",
    "email": "iloveauth@example.com",
    "total_leaves": 20,
    "email_verified_at": null,
    "created_at": "2019-01-25 08:29:46",
    "updated_at": "2019-01-25 09:26:33"
}
```

## Error Response

**Condition** : If bearer token is not valid.

**Code** : `500 INTERNAL SERVER ERROR`

---

**Condition** : If id is not found.

**Code** : `404 NOT FOUND`

---

**Condition** : If you try to update user info of another user.
 
**Code** : `403 FORBIDDEN`
 
**Content** :
 
```json
{
    "error": "You can only edit yourself."
}
```

# Get All Leaves 

Used to collect all leaves for a registered User.

**URL** : `/leaves`

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "data": [
        {
            "id": 1,
            "from": "2018-12-24",
            "until": "2018-12-31",
            "days": "4"
        },
        {
            "id": 2,
            "from": "2018-09-10",
            "until": "2018-09-21",
            "days": "10"
        }
    ]
}
```

## Error Response

**Condition** : If bearer token is not valid.

**Code** : `500 INTERNAL SERVER ERROR`

# Get A Specific Leave 

Used to collect all leaves for a registered User.

**URL** : `/leaves/{id}`

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "data": {
        "id": 1,
        "from": "2018-12-24",
        "until": "2018-12-31",
        "days": "4"
    }
}
```

## Error Response

**Condition** : If bearer token is not valid.

**Code** : `500 INTERNAL SERVER ERROR`

---

**Condition** : If you try to access a leave that belongs to another user.
 
**Code** : `403 FORBIDDEN`
 
**Content** :
 
```json
{
    "error": "You can only view your own leaves."
}
```

---

**Condition** : If id is not found.

**Code** : `404 NOT FOUND`

# Create New Leave 

Used to create a new leave for a registered User.

**URL** : `/leaves`

**Method** : `POST`

**Auth required** : YES

**Data constraints**

```json
{
    "from": "[valid date in plain text and Y-m-d format]",
    "until": "[valid date in plain text and Y-m-d format]"
}
```

**Data example**

```json
{
    "from": "2018-12-24",
    "until": "2018-12-31"
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "data": {
        "id": 4,
        "from": "2018-12-24",
        "until": "2018-12-31",
        "days": 4
    }
}
```

## Error Response

**Condition** : If bearer token is not valid.

**Code** : `500 INTERNAL SERVER ERROR`

---

**Condition** : If dates are in wrong format.
 
**Code** : `422 UNPROCESSABLE ENTITY`
 
**Content** :
 
```json
{
    "error": "From and Until dates must be in Y-m-d format"
}
```

---

**Condition** : If from date is greater than until date.
 
**Code** : `422 UNPROCESSABLE ENTITY`
 
**Content** :
 
```json
{
    "error": "From can not be greater than Until date"
}
```

# Update A Leave 

Used to update an existing leave for a registered User.

**URL** : `/leaves/{id}`

**Method** : `PUT`

**Auth required** : YES

**Data constraints**

```json
{
    "from": "[valid date in plain text and Y-m-d format]",
    "until": "[valid date in plain text and Y-m-d format]"
}
```

**Data example**

```json
{
    "from": "2018-12-27",
    "until": "2018-12-30"
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "data": {
        "id": 1,
        "from": "2018-12-27",
        "until": "2018-12-30",
        "days": 2
    }
}
```

## Error Response

**Condition** : If bearer token is not valid.

**Code** : `500 INTERNAL SERVER ERROR`

---

**Condition** : If dates are in wrong format.
 
**Code** : `422 UNPROCESSABLE ENTITY`
 
**Content** :
 
```json
{
    "error": "From and Until dates must be in Y-m-d format"
}
```

---

**Condition** : If from date is greater than until date.
 
**Code** : `422 UNPROCESSABLE ENTITY`
 
**Content** :
 
```json
{
    "error": "From can not be greater than Until date"
}
```

---

**Condition** : If id is not found.

**Code** : `404 NOT FOUND`

---

**Condition** : If you try to update a leave that belongs to another user.
 
**Code** : `403 FORBIDDEN`
 
**Content** :
 
```json
{
    "error": "You can only edit your own leaves."
}
```

# Delete A Leave 

Used to delete an existing leave for a registered User.

**URL** : `/leaves/{id}`

**Method** : `DELETE`

**Auth required** : YES

## Success Response

**Code** : `204 NO CONTENT`

## Error Response

**Condition** : If bearer token is not valid.

**Code** : `500 INTERNAL SERVER ERROR`

---

**Condition** : If id is not found.

**Code** : `404 NOT FOUND`

---

**Condition** : If you try to delete a leave that belongs to another user.
 
**Code** : `403 FORBIDDEN`
 
**Content** :
 
```json
{
    "error": "You can only delete your own leaves."
}
```