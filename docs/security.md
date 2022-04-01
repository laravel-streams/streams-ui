---
title: Security
category: basics
sort: 99
stage: outlining
enabled: false
---

## Introduction

In addition to the below options we suggest [configuring middleware](configuration#api-middleware) for the UI.

## Authorization

Enable the UI policy to enforce the now *required* [stream policy](/docs/core/streams#security) against the corresponding model [policy method](https://laravel.com/docs/8.x/authorization#policy-methods) (`viewAny`, `view`, `create`, `update`, and `delete`<!-- , `restore`, and `forceDelete` -->).

```json
// streams/contacts.json
{
    "ui.policy": true
}
```

You can also specify a different policy to use for the UI only:

```json
// streams/contacts.json
{
    "ui.policy": "App\\Contacts\\ContactApiPolicy"
}
```

### Fallback Authorization

If you would like to run authorization even if no streams or route policy is specified; you can [configure a fallback policy](configuration#configuring-the-ui).
