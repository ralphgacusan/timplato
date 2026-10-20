# Security testing deployment

The Docker production image enables the isolated security-testing demo. After rebuilding and redeploying the image, open these paths on the deployed app's origin:

- `https://<deployed-host>/signin-test`
- `https://<deployed-host>/review-test`

For a local deployment using `compose.production.yaml`, use `http://localhost:8081/signin-test` and `http://localhost:8081/review-test`.

The sign-in demo credentials are `demo@example.test` and `LabPassword123!`. The pages use intentionally vulnerable demo behavior and dummy data; keep them for controlled security testing only.

The image defaults `SECURITY_TESTING_ENABLED=true`. Deployment environment variables override image defaults, so set `SECURITY_TESTING_ENABLED=true` in `.env.production` or remove any existing `SECURITY_TESTING_ENABLED=false`. Keep `APP_ENV=production` and `APP_DEBUG=false`. The existing container entrypoint caches Laravel configuration at startup, so this setting takes effect on the next container start.

The demo creates its own SQLite database at `storage/framework/security-testing.sqlite`. Lab account lookups and reviews use this file and do not modify the normal application's tables. The normal Laravel bootstrap still reads global settings from the existing application database, so keep your current database configuration. No additional migrations are needed for the lab. The container entrypoint makes `storage` writable. The lab database is excluded from the Docker build context, and its data is ephemeral across redeploys unless that path is backed by persistent storage.
