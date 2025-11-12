---
title: Introduction
description: 'User interface and control panel components for Laravel Streams.'
sort_order: 0
category: core-concepts
status: live
---

# Streams UI

Streams UI is a comprehensive UI component library for Laravel Streams that provides everything you need to build modern, reactive admin panels and control panels. Built on top of Livewire 3, it offers a declarative, component-based approach to building complex user interfaces with minimal effort.

## Overview

Streams UI provides a rich set of pre-built components and builders that handle common UI patterns and interactions. Whether you're building a simple CRUD interface or a complex dashboard, Streams UI gives you the tools to create polished, professional interfaces quickly.

### Key Features

- **Panel System** - Create multi-tenant admin panels with customizable layouts, navigation, and branding
- **Resource Management** - Declarative CRUD interfaces with minimal boilerplate
- **Page Builders** - Flexible page components for custom interfaces
- **Table Builders** - Powerful data tables with sorting, filtering, searching, and bulk actions
- **Form Builders** - Dynamic forms with comprehensive input types and validation
- **Action System** - Reusable actions with modal support, confirmations, and redirects
- **Navigation** - Hierarchical navigation with groups, icons, badges, and active states
- **Widgets** - Dashboard widgets including stats and charts
- **Components** - Rich set of UI components (cards, modals, alerts, badges, etc.)
- **Livewire Integration** - Full reactive experience with Livewire 3
- **Tailwind CSS** - Beautiful, customizable styling with Tailwind CSS
- **Color Management** - Flexible color system with support for primary, success, warning, danger, and custom colors

### Architecture

Streams UI is built around several core concepts:

- **Panels** - Top-level containers that define entire admin interfaces
- **Pages** - Individual routes/screens within a panel
- **Resources** - Automatic CRUD interfaces for Streams entries
- **Builders** - Declarative component builders (Table, Form, etc.)
- **Components** - Livewire components for reactive functionality
- **Actions** - Reusable behaviors that can be attached to buttons, rows, etc.

### Philosophy

Streams UI follows a declarative, builder-pattern approach where you define what you want, not how to build it. The package handles:

- Routing and middleware
- Layout and theming
- State management
- Validation
- Error handling
- Notifications
- Modal interactions
- AJAX requests

This allows you to focus on your application logic while Streams UI handles the UI complexity.
