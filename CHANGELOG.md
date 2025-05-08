# Changelog

## v1.0.8
- add `formSelectWithAuth`.

## v1.0.7:
- add icons to `TextEntry` and `TextColumn`.
- add the ability to display the state without icon by passing `true` with functions `textEntry(without_icon: true)`, `textColumn(without_icon: true)`, and `display(without_icon: true)`
- add action group so you can group the actions and display current state as label.

### v1.0.6:
- include table filters `StateFilterService::make(static::getModel())->tableFilter()`.
- prevent State from shown in actions even if the authorization disabled based on `canTransitionTo()` method.