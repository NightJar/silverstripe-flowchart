# Silverstripe Flowchart

A module to create an interactive flowchart.

## Installation

    $ composer require chtombleson/silverstripe-flowchart

## Usage

Once installed and the dev/build has been run. In the CMS there should be a Flowcharts
section. Where you can create a new Flowchart and add questions.

### Flowchart options

  * Voting Disabled - Disables rating of flowchart from 1 to 5.
  * Feedback Disabled - Disables feedback for the flowchart.

### Question options

  * Question Heading - Optional the default is Question 1 etc.
  * Question Description Content - Optional used for additional info about the question.
  * Answer - The final outcome of the flowchart.

### Responses

Responses are used to link question to other questions.

  * Response Label - For example Yes or No.
  * Next Question - The question to go to if that response is selected.

## Upgrade notes

> [!WARNING]
> Sites upgrading to a Silverstripe CMS 6+ compatible version may need to choose a mitigation option to deal with a
> change in database table naming behaviour

### Problem background

This module was originally built for SilverStripe 3. Silverstripe 4 introduced namespacing, which carried through to the
naming of database tables. This new behaviour could be altered via a `table_name` configuration property in order to
avoid data going "missing" as new (empty) tables would otherwise be built by `dev/build` upon upgrade of existing sites.

```php
// in a DataObject class context
private static $table_name = 'ShortClassname';
```

Corresponding to `silverstripe/config` setting of

```yml
Fully\Qualified\Classname:
  table_name: ShortClassname
```

**This module did not implement `table_name` on its Silverstripe 4 or Silverstripe CMS 5 compatible versions.**

Sites upgrading from SilverStripe 3 may not be impacted by the following if they implement the configuration above to
deal with the issue when upgrading to CMS 4. Those who chose a SQL migration instead will still need to read on

### Resolution options

The CMS 6 version of this module starts implementing the table name configuration, resulting in the same problem
outlined above in reverse - **existing sites with database table names such as `ChTombleson_Flowchart_Models_Flowchart`**
will suddenly have & use a new table with no data named `Flowchart` - all existing flowcharts on the site will disappear.

To avoid data "loss" (still in the database, just inaccessible by default), one can either:

- Copy existing data from the old table to the new with an SQL statement and then drop the old table
- Use the configuration values above to set the `table_name` values of the relevant classes back to whatever the
  projects tables are named

The latter option would look something like:

```yml
ChTombleson\Flowchart\Models\Flowchart:
  table_name: ChTombleson_Flowchart_Models_Flowchart
```

A migration strategy will need to be applied to all 5 DataObjects present in the older versions:

- Flowchart
- FlowchartFeedback
- FlowchartQuestion
- FlowchartResponse
- FlowchartVote
