---
title: Introduction
intro:
enabled: true
---

## User Interface

The user's interface, including a control panel, is an optional core component of the Streams platform. The UI system extends the [stream domain information](streams#domain-information).

### Input Types

Input types separate the concerns of [data-modeling](domain-entities) vs. data-management and provide a refreshing new layer of flexibility.

- [Input Types](inputs)

### UI Components

Several flexible UI components are available and can be used both within and outside of a control panel. We use a factory-like `builder` pattern and utilize [Svelte](https://svelte.dev/) to provide native JS components where applicable.

- [Builders](builders)
- [Components](components)

### Control Panel

The Streams platform provides a consistent, user-friendly, and "hella-performant" control panel that puts you in control of every aspect. Zero configuration is necessary by default.

- [Control Panel](cp)
