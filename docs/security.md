---
title: Security
category: basics
sort: 99
stage: outlining
enabled: true
---

## Introduction

In addition to the below stream options we suggest [configuring middleware](configuration#control-panel-middleware) for the [Control Panel](cp).

## Authorization

Enable the CP policy to enforce the now *required* [stream policy](/docs/core/streams#security) against the corresponding model [policy method](https://laravel.com/docs/8.x/authorization#policy-methods) (`viewAny`, `view`, `create`, `update`, and `delete`<!-- , `restore`, and `forceDelete` -->).

```json
// streams/contacts.json
{
    "ui.cp.policy": true
}
```

You can also specify a different policy to use for the CP only:

```json
// streams/contacts.json
{
    "ui.cp.policy": "App\\Contacts\\ContactCpPolicy"
}
```

### Fallback Authorization

If you would like to run authorization even if no streams or route policy is specified; you can [configure a fallback policy](configuration#configuring-the-api).
