# Symfony Messenger

- Async/sync
  - `git checkout initial`
  - `git checkout async`
  - `composer require symfony/messenger`
  - Created message
  - Added message to messenger config
    - Messenger DSN
  - Moved letter service to handler
    - Doctrine entities as id
- Process messages
  - Show messages in DB
  - `php bin/console messenger:consume -vv`
  - Edit consume, restart consumer 
- Failure handling
- Different transports/busses
  - Also interface for routing (multiple transports)
  - Sync transport (debugging, design pattern,...)
- Middleware
- Envelopes & Stamps

- Differences between Laravel Horizon?
