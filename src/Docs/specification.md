# Package vadiasov/upload specification
## Interaction
Example:
* Album needs in tracks
* We are on the Album page. We click on button "Upload Tracks" and go to "Upload page".
* Upload page has drop zone.
* Drug and drop files.
* Files goes through validation.
* If validation is ok file thumb has check sign.
    * Otherwise file thumb has christ sign.
* If validation of file is ok this one is saved into a server and filename is saved into appropriate DB table.
* We click on the button "Back" and we go to the previous page Album page.

## Requirements
* we need to pass into the package:
    * validation rules
    * directory to save real files
    * DB table and columns to save file names
    * action/route etc to come back from package

## Technology to pass data into the package
* We create in a parent (calling ) package/module etc an array in a config with all required data
* in a URL to Upload Package Page we add name of array (maybe config + array) as a segment.