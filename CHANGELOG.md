# Changelog

### v1.0.6:
- include table filters `StateFilterService::make(static::getModel())->tableFilter()`.
- prevent State from shown in actions even if the authorization disabled based on `canTransitionTo()` method.