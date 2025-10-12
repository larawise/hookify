## Version : About
In order to protect the semantic versioning mentality, we thought that it would be more accurate to proceed with a
certain mentality in version upgrades. For this reason, we created a release algorithm. Detailed information about
this release algorithm is given below.

- `MAIN` - `UPDATE` - `PATCH`
    - When we make a major change that is incompatible with the previous version, a version jump occurs in the **"MAIN"** part. (**2**.0.0)
    - When we make an update / change compatible with the previous version, a version jump occurs in the **"UPDATE"** section. (2.**1**.0)
    - When we make / apply a bug fix compatible with the previous version, a version jump occurs in the **"PATCH"** section. (2.1.**1**)

By continuously following the version updates of the official Laravel project, after the new version is released, the work to ensure
compatibility with that version will be completed quickly and the version compatible with the new version will always be published
urgently.

## Version : Schema

| Product Version | Product Last Support Date | Product Release Date | Target | LTS | Status |
|-----------------|---------------------------|----------------------|:------:|:---:|:------:|
| v1.x.x          | August 13th, 2026         | February 24th, 2025  | `12.x` |  ❌  |   ⏳    |
| v2.x.x          | Q1 2027                   | Q1 2026              | `13.x` |  ❌  |   ⏳    |
| v3.x.x          | Q1 2028                   | Q1 2027              | `14.x` |  ❌  |   ⏳    |
| v4.x.x          | Q1 2029                   | Q1 2028              | `15.x` |  ❌  |   ⏳    |
| v5.x.x          | Q1 2030                   | Q1 2029              | `16.x` |  ❌  |   ⏳    |
| v6.x.x          | Q1 2031                   | Q1 2030              | `17.x` |  ❌  |   ⏳    |

> **Note**
> Version release dates may be earlier, it's just planned this way so that it can be followed by the entire community.

## Version : Information
- The support life of the versions marked as LTS is determined as 3 years.
- The support life of the versions marked as Non-LTS is determined as 1 year.
- Each value in the target column corresponds to expansion packs for a specific Laravel version.
- It means that the versions marked in the status column are actively published.
- **Selçuk Çukur** always reserves the right to change the release date of the version.
