# FlexPress image size component

## Install with Pimple
The image size component uses two classes:
- AbstractImageSize, which you extend to create a image size.
- ImageSizeHelper, which hooks into everything for you and registeres the image sizes.
- Lets create a pimple config for both of these

```
$pimple["featureImageSize"] = function () {
  return new FeatureImageSize();
};

$this['imageSizeHelper'] = function ($c) {
    return new ImageSizeHelper($c['objectStorage'], array(
        $c["featureImageSize"]
    ));
};
```
- Note the dependency $c['objectStorage']  is a SPLObjectStorage

## Creating a concreate ImageSize class
Create a concreate class that implements the AbstractImageSize class and implements the getName(), getHeight() and getWidth() methods.

```
class Feature extends AbstractImageSize {

    public function getName()
    {
        return "Feature";
    }

    public function getHeight()
    {
        return 200;
    }

    public function getWidth()
    {
        return 600;
    }
}
```
This above example is the bare minimum you must implement, the example that follows is the other extreamm implementing all available methods.
```
class Feature extends AbstractImageSize {

    public function getName()
    {
        return "Feature";
    }

    public function getHeight()
    {
        return 200;
    }

    public function getWidth()
    {
        return 600;
    }
    
    public function getCrop()
    {
        return false;
    }
    
    public function shouldShowInCMS()
    {
        return false;
    }
    
}
```

### Public Methods
- getName() - returns the name of the image size.
- getHeight() - returns the height of the image size.
- getWidth() - returns the width of the image size.
- getCrop() - Boolean value to state if the image should be cropped.
- shouldShowInCMS() - Whether the image size should be selectable in the CMS, e.g. when inserting media into a post

## ImageSizeHelper usage

- Once you have setup the pimple config you are use the ImageSizeHelper like this
```
$helper = $pimple['imageSizeHelper'];
$helper->registerImageSizes();

```
That's it, the helper will then add all the needed hooks and register all the image sizes you have provided it.

### Public methods
- imageSizeNamesChoose() - Used by a hook to add the images to the available image sizes in WordPress UI (uses the shouldShowInCMS method of the imagesize class.
- registerImageSizes() - Used by a hook to add the image sizes provided.
