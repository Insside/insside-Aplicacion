<?php
$root = (!isset($root)) ? "../../../../" : $root;
require_once($root . "librerias/Configuracion.cnf.php");
require_once($root . "modulos/aplicacion/librerias/Compactador.class.php");
require_once($root . "modulos/aplicacion/librerias/Aplicacion_Framework_Clases.class.php");
header('Content-Type: application/x-javascript');
$afc = new Aplicacion_Framework_Clases();
?>
var MUI = InssideUI = {
  'version': '2.0.0 development',
  'idCount': 0,
  'instances': new Hash(),
  'registered': new Hash(),
  'options': {
    'theme': 'default',
    'advancedEffects': false, // Effects that require fast browsers and are cpu intensive.
    'standardEffects': true   // Basic effects that tend to run smoothly.
  },
  'path': {
    source: 'scripts/source/',
    themes: 'themes/',
    plugins: 'plugins/',
    modulos: 'modulos/',
    pqrs: 'modulos/solicitudes/',
    proveedores: 'modulos/proveedores/',
    usuarios: 'modulos/usuarios/',
    distribucion: 'modulos/distribucion/',
    suscriptores: 'modulos/suscriptores/',
    comunicaciones: 'modulos/comunicaciones/',
    empleados: 'modulos/empleados/',
    inventarios: 'modulos/inventarios/',
    medidores: 'modulos/medidores/',
    sincronizacion: 'modulos/sincronizacion/',
    aplicacion: 'modulos/aplicacion/',
    estilos: 'estilos/'
  },
  // Returns the path to the current theme directory
  'themePath': function () {
    return MUI.path.themes + MUI.options.theme + '/';
  },
  'set': function (el, instance) {
    el = this.getID(el);
    this.instances.set(el, instance);
    return instance;
  },
  'getData': function (item, property, dfault) {
    if (!dfault)
      dfault = '';
    if (!item || !property)
      return dfault;
    if (item[property] == null)
      return dfault;
    return item[property];
  },
  'getID': function (el) {
    var type = typeOf(el);
    if (type == 'null')
      return null;
    if (type == 'function') {
      return el;
    }
    if (type == 'string')
      return el;
    if (type == 'element')
      return el.id;
    else if (type == 'object' && el.id)
      return el.id;
    else if (type == 'object' && el.options && el.options.id)
      return el.options.id;
    return el;
  },
  'get': function (el) {
    var id = this.getID(el);
    el = $(id);
    if (el && el.retrieve('instance'))
      return el.retrieve('instance');
    return this.instances[id];
  },
  'files': new Object(),
  'dockWrapper': 'dockWrapper',
  'dock': 'dock',
  'Columns': {'instances': new Hash(),'columnIDCount': 0},
  'Panels': {'instances': new Hash(),'panelIDCount': 0 },
    // Panel Height
  'panelHeight': function(column, changing, action) {
    if (column != null) {
      MUI.panelHeight2($(column), changing, action);
    }
    else {
      $$('.column').each(function(column) {
        MUI.panelHeight2(column);
      }.bind(this));
    }
  },
  /*
   
   actions can be new, collapsing or expanding.
   
   */
  'panelHeight2': function(column, changing, action) {

    var instances = MUI.Panels.instances;

    var parent = column.getParent();
    var columnHeight = parent.getStyle('height').toInt();
    if (Browser.ie4 && parent == MUI.Desktop.pageWrapper) {
      columnHeight -= 1;
    }
    column.setStyle('height', columnHeight);

    // Get column panels
    var panels = [];
    column.getChildren('.panelWrapper').each(function(panelWrapper) {
      panels.push(panelWrapper.getElement('.panel'));
    }.bind(this));

    // Get expanded column panels
    var panelsExpanded = [];
    column.getChildren('.expanded').each(function(panelWrapper) {
      panelsExpanded.push(panelWrapper.getElement('.panel'));
    }.bind(this));

    // All the panels in the column whose height will be effected.
    var panelsToResize = [];

    // The panel with the greatest height. Remainders will be added to this panel
    var tallestPanel;
    var tallestPanelHeight = 0;

    this.panelsTotalHeight = 0; // Height of all the panels in the column
    this.height = 0; // Height of all the elements in the column

    // Set panel resize partners
    panels.each(function(panel) {
      /** 1.2 @todo */
      var instance = instances.get(panel.id);
      if (panel.getParent().hasClass('expanded') && panel.getParent().getNext('.expanded')) {
        instance.partner = panel.getParent().getNext('.expanded').getElement('.panel');
        instance.resize.attach();
        instance.handleEl.setStyles({
          'display': 'block',
          'cursor': Browser.firefox ? 'row-resize' : 'n-resize'
        }).removeClass('detached');
      } else {
        try {
          instance.resize.detach();
        } catch (error) {
        }
        instance.handleEl.setStyles({
          'display': 'none',
          'cursor': null
        }).addClass('detached');
      }
      if (panel.getParent().getNext('.panelWrapper') == null) {
        instance.handleEl.hide();
      }
    }.bind(this));

    // Add panels to panelsToResize
    // Get the total height of all the resizable panels
    // Get the total height of all the column's children
    column.getChildren().each(function(panelWrapper) {

      panelWrapper.getChildren().each(function(el) {

        if (el.hasClass('panel')) {
          /** 1.2 @todo */
          var instance = instances.get(el.id);

          // Are any next siblings Expanded?
          var anyNextSiblingsExpanded = function(el) {
            var test;
            el.getParent().getAllNext('.panelWrapper').each(function(sibling) {
              /** 1.2 @todo */
              var siblingInstance = instances.get(sibling.getElement('.panel').id);
              if (siblingInstance.isCollapsed == false) {
                test = true;
              }
            }.bind(this));
            return test;
          }.bind(this);

          // If a next sibling is expanding, are any of the nexts siblings of the expanding sibling Expanded?
          var anyExpandingNextSiblingsExpanded = function(el) {
            var test;
            changing.getParent().getAllNext('.panelWrapper').each(function(sibling) {
              /** 1.2 @todo */
              var siblingInstance = instances.get(sibling.getElement('.panel').id);
              if (siblingInstance.isCollapsed == false) {
                test = true;
              }
            }.bind(this));
            return test;
          }.bind(this);

          // Is the panel that is collapsing, expanding, or new located after this panel?
          var anyNextContainsChanging = function(el) {
            var allNext = [];
            el.getParent().getAllNext('.panelWrapper').each(function(panelWrapper) {
              allNext.push(panelWrapper.getElement('.panel'));
            }.bind(this));
            var test = allNext.contains(changing);
            return test;
          }.bind(this);

          var nextExpandedChanging = function(el) {
            var test;
            if (el.getParent().getNext('.expanded')) {
              if (el.getParent().getNext('.expanded').getElement('.panel') == changing)
                test = true;
            }
            return test;
          }

          // NEW PANEL
          // Resize panels that are "new" or not collapsed
          if (action == 'new') {
            if (!instance.isCollapsed && el != changing) {
              panelsToResize.push(el);
              this.panelsTotalHeight += el.offsetHeight.toInt();
            }
          }

          // COLLAPSING PANELS and CURRENTLY EXPANDED PANELS
          // Resize panels that are not collapsed.
          // If a panel is collapsing resize any expanded panels below.
          // If there are no expanded panels below it, resize the expanded panels above it.
          else if (action == null || action == 'collapsing') {
            if (!instance.isCollapsed && (!anyNextContainsChanging(el) || !anyNextSiblingsExpanded(el))) {
              panelsToResize.push(el);
              this.panelsTotalHeight += el.offsetHeight.toInt();
            }
          }

          // EXPANDING PANEL
          // Resize panels that are not collapsed and are not expanding.
          // Resize any expanded panels below the expanding panel.
          // If there are no expanded panels below the expanding panel, resize the first expanded panel above it.
          else if (action == 'expanding' && !instance.isCollapsed && el != changing) {
            if (!anyNextContainsChanging(el) || (!anyExpandingNextSiblingsExpanded(el) && nextExpandedChanging(el))) {
              panelsToResize.push(el);
              this.panelsTotalHeight += el.offsetHeight.toInt();
            }
          }

          if (el.style.height) {
            this.height += el.getStyle('height').toInt();
          }
        }
        else {
          this.height += el.offsetHeight.toInt();
        }
      }.bind(this));

    }.bind(this));

    // Get the remaining height
    var remainingHeight = column.offsetHeight.toInt() - this.height;

    this.height = 0;

    // Get height of all the column's children
    column.getChildren().each(function(el) {
      this.height += el.offsetHeight.toInt();
    }.bind(this));

    var remainingHeight = column.offsetHeight.toInt() - this.height;

    panelsToResize.each(function(panel) {
      var ratio = this.panelsTotalHeight / panel.offsetHeight.toInt();
      var newPanelHeight = panel.getStyle('height').toInt() + (remainingHeight / ratio);
      if (newPanelHeight < 1) {
        newPanelHeight = 0;
      }
      panel.setStyle('height', newPanelHeight);
    }.bind(this));

    // Make sure the remaining height is 0. If not add/subtract the
    // remaining height to the tallest panel. This makes up for browser resizing,
    // off ratios, and users trying to give panels too much height.

    // Get height of all the column's children
    this.height = 0;
    column.getChildren().each(function(panelWrapper) {
      panelWrapper.getChildren().each(function(el) {
        this.height += el.offsetHeight.toInt();
        if (el.hasClass('panel') && el.getStyle('height').toInt() > tallestPanelHeight) {
          tallestPanel = el;
          tallestPanelHeight = el.getStyle('height').toInt();
        }
      }.bind(this));
    }.bind(this));

    var remainingHeight = column.offsetHeight.toInt() - this.height;

    if (remainingHeight != 0 && tallestPanelHeight > 0) {
      tallestPanel.setStyle('height', tallestPanel.getStyle('height').toInt() + remainingHeight);
      if (tallestPanel.getStyle('height') < 1) {
        tallestPanel.setStyle('height', 0);
      }
    }

    parent.getChildren('.columnHandle').each(function(handle) {
      var parent = handle.getParent();
      if (parent.getStyle('height').toInt() < 1)
        return; // Keeps IE7 and 8 from throwing an error when collapsing a panel within a panel
      var handleHeight = parent.getStyle('height').toInt() - handle.getStyle('border-top').toInt() - handle.getStyle('border-bottom').toInt();
      if (Browser.ie4 && parent == MUI.Desktop.pageWrapper) {
        handleHeight -= 1;
      }
      handle.setStyle('height', handleHeight);
    });

    panelsExpanded.each(function(panel) {
      MUI.resizeChildren(panel);
    }.bind(this));

  },
  // May rename this resizeIframeEl()
  'resizeChildren': function(panel) {
    /** 1.2 @todo */
    var instances = MUI.Panels.instances;
    var instance = instances.get(panel.id);
    var contentWrapperEl = instance.contentWrapperEl;

    if (instance.iframeEl) {
      if (!Browser.ie) {
        instance.iframeEl.setStyles({
          'height': contentWrapperEl.getStyle('height'),
          'width': contentWrapperEl.offsetWidth - contentWrapperEl.getStyle('border-left').toInt() - contentWrapperEl.getStyle('border-right').toInt()
        });
      }
      else {
        // The following hack is to get IE8 RC1 IE8 Standards Mode to properly resize an iframe
        // when only the vertical dimension is changed.
        instance.iframeEl.setStyles({
          'height': contentWrapperEl.getStyle('height'),
          'width': contentWrapperEl.offsetWidth - contentWrapperEl.getStyle('border-left').toInt() - contentWrapperEl.getStyle('border-right').toInt() - 1
        });
        instance.iframeEl.setStyles({
          'width': contentWrapperEl.offsetWidth - contentWrapperEl.getStyle('border-left').toInt() - contentWrapperEl.getStyle('border-right').toInt()
        });
      }
    }

  },
  'remainingWidth': function(container) {
    container=(container)?container:MUI.Desktop.desktop;
    container.getElements('.remainingWidth').each(function(column) {
      var currentWidth = column.offsetWidth.toInt();
      currentWidth -= column.getStyle('border-left').toInt();
      currentWidth -= column.getStyle('border-right').toInt();

      var parent = column.getParent();
      this.width = 0;

      // Get the total width of all the parent element's children
      parent.getChildren().each(function(el) {
        if (el.hasClass('insside') != true) {
          this.width += el.offsetWidth.toInt();
        }
      }.bind(this));

      // Add the remaining width to the current element
      var remainingWidth = parent.offsetWidth.toInt() - this.width;
      var newWidth = currentWidth + remainingWidth;
      if (newWidth < 1)
        newWidth = 0;
      column.setStyle('width', newWidth);
      column.getChildren('.panel').each(function(panel) {
        panel.setStyle('width', newWidth - panel.getStyle('border-left').toInt() - panel.getStyle('border-right').toInt());
        MUI.resizeChildren(panel);
      }.bind(this));

    });
  }
};
/** <mui>Clases Incorporadas al MUI **/
<?php
$db = new MySQL();
$sql = "SELECT * FROM `aplicacion_framework_clases` WHERE(`nombre` LIKE  '%MUI.%' AND `estado` = 'ACTIVA');";
$consulta = $db->sql_query($sql);
while ($fila = $db->sql_fetchrow($consulta)) {
  echo ($afc->codensador($fila['clase']));
}
?>
/** </mui>Clases Incorporadas al MUI **/
Object.append(MUI, {

});

















MUI.files[MUI.path.source + 'Core/Core.js'] = 'loaded';

Object.append(MUI, {
  Windows: {
    //instances: new Hash()
    instances: new Object()
  },
  ieSupport: 'excanvas', // Makes it easier to switch between Excanvas and Moocanvas for testing
  /**
   Function: updateContent
   Remplaza el contenido de un Panel o Ventana   
   Argumentos: updateOptions - (object)
   updateOptions:
   element - The parent window or panel.
   childElement - The child element of the window or panel recieving the content.
   method - ('get', or 'post') The way data is transmitted.
   data - (hash) Data to be transmitted
   title - (string) Change this if you want to change the title of the window or panel.
   content - (string or element) An html loadMethod option.
   loadMethod - ('html', 'xhr', or 'iframe')
   url - Used if loadMethod is set to 'xhr' or 'iframe'.
   scrollbars - (boolean)
   padding - (object)
   onContentLoaded - (function)
   **/
  updateContent: function (options) {
    var options = Object.append({
      element: null,
      childElement: null,
      method: null,
      data: null,
      title: null,
      content: null,
      loadMethod: null,
      url: null,
      scrollbars: null,
      padding: null,
      require: {},
      onContentLoaded: function () {
      }
    }, options);
    options.require = Object.append({
      css: [],
      images: [],
      js: [],
      onload: null
    }, options.require);
    var args = {};
    if (!options.element)
      return;
    var element = options.element;

    /** 1.2 @todo */
    //if (MUI.Windows.instances.get(element.id)){
    if (MUI.Windows.instances.element) {
      args.recipient = 'window';
    }
    else {
      args.recipient = 'panel';
    }
    var instance = element.retrieve('instance');
    if (options.title) {
      instance.titleEl.set('html', options.title);
    }
    var contentEl = instance.contentEl;
    args.contentContainer = options.childElement != null ? options.childElement : instance.contentEl;
    var contentWrapperEl = instance.contentWrapperEl;
    if (!options.loadMethod) {
      if (!instance.options.loadMethod) {
        if (!options.url) {
          options.loadMethod = 'html';
        }
        else {
          options.loadMethod = 'xhr';
        }
      }
      else {
        options.loadMethod = instance.options.loadMethod;
      }
    }
    // Set scrollbars if loading content in main content container.
    // Always use 'hidden' for iframe windows
    var scrollbars = options.scrollbars || instance.options.scrollbars;
    if (args.contentContainer == instance.contentEl) {
      contentWrapperEl.setStyles({
        'overflow': scrollbars != false && options.loadMethod != 'iframe' ? 'auto' : 'hidden'
      });
    }

    if (options.padding != null) {
      contentEl.setStyles({
        'padding-top': options.padding.top,
        'padding-bottom': options.padding.bottom,
        'padding-left': options.padding.left,
        'padding-right': options.padding.right
      });
    }

    /**
     * Autor: Jose Alexis Correa Valencia 
     * Recargar Barra De Herramientas: Este procedimiento era inexistente y permite recargar las barras 
     * herramientas aosicadas aun panel u objeto al actualizar el contenido del mismo
     * options.headerToolbox: Estado barra de herramientas
     * options.headerToolboxURL: Url pasada en las opciones
     * instance.panelHeaderToolboxEl: Elemento Contenedor
     **/
    if (options.headerToolbox) {
      if (options.headerToolboxURL) {
        new Request.HTML({
          url: options.headerToolboxURL,
          update: instance.panelHeaderToolboxEl,
          method: options.headerToolboxMethod != null ? options.headerToolboxMethod : 'get',
          data: options.headerToolboxData != null ? Object.toQueryString(options.headerToolboxData) : '',
          evalScripts: true,
          evalResponse: false,
          onRequest: function () {
          }.bind(this),
          onFailure: function (response) {
          }.bind(this),
          onSuccess: function () {
          }.bind(this),
          onComplete: function () {
          }.bind(this)
        }).send();
      }
    }
    /** Remove old content. **/
    if (args.contentContainer == contentEl) {
      contentEl.empty().show();
      // Panels are not loaded into the padding div, so we remove them separately.
      contentEl.getAllNext('.column').destroy();
      contentEl.getAllNext('.columnHandle').destroy();
    }
    args.onContentLoaded = function () {
      if (options.require.js.length || typeof options.require.onload == 'function') {
        new MUI.Require({
          js: options.require.js,
          onload: function () {
            if (Browser.opera) {
              options.require.onload.delay(100);
            }
            else {
              options.require.onload();
            }
            options.onContentLoaded ? options.onContentLoaded() : instance.fireEvent('onContentLoaded', element);
          }.bind(this)
        });
      }
      else {
        options.onContentLoaded ? options.onContentLoaded() : instance.fireEvent('onContentLoaded', element);
      }

    };
    if (options.require.css.length || options.require.images.length) {
      new MUI.Require({
        css: options.require.css,
        images: options.require.images,
        onload: function () {
          this.loadSelect(instance, options, args);
        }.bind(this)
      });
    }
    else {
      this.loadSelect(instance, options, args);
    }
  },
  loadSelect: function (instance, options, args) {

    // Load new content.
    switch (options.loadMethod) {
      case 'xhr':
        this.updateContentXHR(instance, options, args);
        break;
      case 'iframe':
        this.updateContentIframe(instance, options, args);
        break;
      case 'html':
      default:
        this.updateContentHTML(instance, options, args);
        break;
    }

  },
  updateContentXHR: function (instance, options, args) {
    var contentEl = instance.contentEl;
    var contentContainer = args.contentContainer;
    var onContentLoaded = args.onContentLoaded;
    new Request.HTML({
      url: options.url,
      update: contentContainer,
      method: options.method != null ? options.method : 'get',
      data: options.data != null ? Object.toQueryString(options.data) : '',
      evalScripts: instance.options.evalScripts,
      evalResponse: instance.options.evalResponse,
      onRequest: function () {
        if (args.recipient == 'window' && contentContainer == contentEl) {
          instance.showSpinner();
        } else if (args.recipient == 'panel' && contentContainer == contentEl && $('spinner')) {
          $('spinner').show();
        }
      }.bind(this),
      onFailure: function (response) {
        if (contentContainer == contentEl) {
          var getTitle = new RegExp("<title>[\n\r\s]*(.*)[\n\r\s]*</title>", "gmi");
          var error = getTitle.exec(response.responseText);
          if (!error)
            error = 'Unknown';
          contentContainer.set('html', '<h3>Error: ' + error[1] + '</h3>');
          if (args.recipient == 'window') {
            instance.hideSpinner();
          }
          else if (args.recipient == 'panel' && $('spinner')) {
            $('spinner').hide();
          }
        }
      }.bind(this),
      onSuccess: function () {
        if (contentContainer == contentEl) {
          if (args.recipient == 'window')
            instance.hideSpinner();
          else if (args.recipient == 'panel' && $('spinner'))
            $('spinner').hide();
        }
        Browser.ie4 ? onContentLoaded.delay(750) : onContentLoaded();
      }.bind(this),
      onComplete: function () {
      }.bind(this)
    }).send();
  },
  updateContentIframe: function (instance, options, args) {
    var contentEl = instance.contentEl;
    var contentContainer = args.contentContainer;
    var contentWrapperEl = instance.contentWrapperEl;
    var onContentLoaded = args.onContentLoaded;
    if (instance.options.contentURL == '' || contentContainer != contentEl) {
      return;
    }
    instance.iframeEl = new Element('iframe', {
      'id': instance.options.id + '_iframe',
      'name': instance.options.id + '_iframe',
      'class': 'inssideIframe',
      'src': options.url,
      'marginwidth': 0,
      'marginheight': 0,
      'frameBorder': 0,
      'scrolling': 'auto',
      'styles': {
        'height': contentWrapperEl.offsetHeight - contentWrapperEl.getStyle('border-top').toInt() - contentWrapperEl.getStyle('border-bottom').toInt(),
        'width': instance.panelEl ? contentWrapperEl.offsetWidth - contentWrapperEl.getStyle('border-left').toInt() - contentWrapperEl.getStyle('border-right').toInt() : '100%'
      }
      /** }).injectInside(contentEl); **/
    }).inject(contentEl); // default is bottom inside desktop div


    // Add onload event to iframe so we can hide the spinner and run onContentLoaded()
    instance.iframeEl.addEvent('load', function (e) {
      if (args.recipient == 'window')
        instance.hideSpinner();
      else if (args.recipient == 'panel' && contentContainer == contentEl && $('spinner'))
        $('spinner').hide();
      Browser.ie4 ? onContentLoaded.delay(50) : onContentLoaded();
    }.bind(this));
    if (args.recipient == 'window')
      instance.showSpinner();
    else if (args.recipient == 'panel' && contentContainer == contentEl && $('spinner'))
      $('spinner').show();
  },
  updateContentHTML: function (instance, options, args) {
    var contentEl = instance.contentEl;
    var contentContainer = args.contentContainer;
    var onContentLoaded = args.onContentLoaded;
    var elementTypes = new Array('element', 'textnode', 'whitespace', 'collection');

    /** 1.2 if (elementTypes.contains($type(options.content))){ */
    if (elementTypes.contains(typeOf(options.content))) {
      options.content.inject(contentContainer);

    } else {
      contentContainer.set('html', options.content);
    }
    if (contentContainer == contentEl) {
      if (args.recipient == 'window')
        instance.hideSpinner();
      else if (args.recipient == 'panel' && $('spinner'))
        $('spinner').hide();
    }
    Browser.ie4 ? onContentLoaded.delay(50) : onContentLoaded();
  },
  /*
   
   Function: reloadIframe
   Reload an iframe. Fixes an issue in Firefox when trying to use location.reload on an iframe that has been destroyed and recreated.
   
   Arguments:
   iframe - This should be both the name and the id of the iframe.
   
   Syntax:
   (start code)
   MUI.reloadIframe(element);
   (end)
   
   Example:
   To reload an iframe from within another iframe:
   (start code)
   parent.MUI.reloadIframe('myIframeName');
   (end)
   
   */
  reloadIframe: function (iframe) {
    Browser.firefox ? $(iframe).src = $(iframe).src : top.frames[iframe].location.reload(true);
  },
  roundedRect: function (ctx, x, y, width, height, radius, rgb, a) {
    ctx.fillStyle = 'rgba(' + rgb.join(',') + ',' + a + ')';
    ctx.beginPath();
    ctx.moveTo(x, y + radius);
    ctx.lineTo(x, y + height - radius);
    ctx.quadraticCurveTo(x, y + height, x + radius, y + height);
    ctx.lineTo(x + width - radius, y + height);
    ctx.quadraticCurveTo(x + width, y + height, x + width, y + height - radius);
    ctx.lineTo(x + width, y + radius);
    ctx.quadraticCurveTo(x + width, y, x + width - radius, y);
    ctx.lineTo(x + radius, y);
    ctx.quadraticCurveTo(x, y, x, y + radius);
    ctx.fill();
  },
  triangle: function (ctx, x, y, width, height, rgb, a) {
    ctx.beginPath();
    ctx.moveTo(x + width, y);
    ctx.lineTo(x, y + height);
    ctx.lineTo(x + width, y + height);
    ctx.closePath();
    ctx.fillStyle = 'rgba(' + rgb.join(',') + ',' + a + ')';
    ctx.fill();
  },
  circle: function (ctx, x, y, diameter, rgb, a) {
    ctx.beginPath();
    ctx.arc(x, y, diameter, 0, Math.PI * 2, true);
    ctx.fillStyle = 'rgba(' + rgb.join(',') + ',' + a + ')';
    ctx.fill();
  },
  notification: function (message) {
    new MUI.Window({
      loadMethod: 'html',
      closeAfter: 1500,
      type: 'notification',
      addClass: 'notification',
      content: message,
      width: 220,
      height: 40,
      y: 53,
      padding: {top: 10, right: 12, bottom: 10, left: 12},
      shadowBlur: 5
    });
  },
  /**
   
   Function: toggleEffects
   Turn effects on and off
   
   */
  toggleAdvancedEffects: function (link) {
    if (MUI.options.advancedEffects == false) {
      MUI.options.advancedEffects = true;
      if (link) {
        this.toggleAdvancedEffectsLink = new Element('div', {
          'class': 'check',
          'id': 'toggleAdvancedEffects_check'
        }).inject(link);
      }
    }
    else {
      MUI.options.advancedEffects = false;
      if (this.toggleAdvancedEffectsLink) {
        this.toggleAdvancedEffectsLink.destroy();
      }
    }
  },
  /*
   
   Function: toggleStandardEffects
   Turn standard effects on and off
   
   */
  toggleStandardEffects: function (link) {
    if (MUI.options.standardEffects == false) {
      MUI.options.standardEffects = true;
      if (link) {
        this.toggleStandardEffectsLink = new Element('div', {
          'class': 'check',
          'id': 'toggleStandardEffects_check'
        }).inject(link);
      }
    }
    else {
      MUI.options.standardEffects = false;
      if (this.toggleStandardEffectsLink) {
        this.toggleStandardEffectsLink.destroy();
      }
    }
  },
  /*
   
   The underlay is inserted directly under windows when they are being dragged or resized
   so that the cursor is not captured by iframes or other plugins (such as Flash)
   underneath the window.
   
   */
  underlayInitialize: function () {
    var windowUnderlay = new Element('div', {
      'id': 'windowUnderlay',
      'styles': {
        //'height': parent.getCoordinates().height,
        //'height': this.getCoordinates().height,

        'opacity': .01,
        'display': 'none'
      }
    }).inject(document.body);
  },
  setUnderlaySize: function () {
    //$('windowUnderlay').setStyle('height', parent.getCoordinates().height);
  }
});



/*
 
 function: fixPNG
 Bob Osola's PngFix for IE6.
 
 example:
 (begin code)
 <img src="xyz.png" alt="foo" width="10" height="20" onload="fixPNG(this)">
 (end)
 
 note:
 You must have the image height and width attributes specified in the markup.
 
 */

function fixPNG(myImage) {
  if (Browser.ie4 && document.body.filters) {
    var imgID = (myImage.id) ? "id='" + myImage.id + "' " : "";
    var imgClass = (myImage.className) ? "class='" + myImage.className + "' " : "";
    var imgTitle = (myImage.title) ? "title='" + myImage.title + "' " : "title='" + myImage.alt + "' ";
    var imgStyle = "display:inline-block;" + myImage.style.cssText;
    var strNewHTML = "<span " + imgID + imgClass + imgTitle
            + " style=\"" + "width:" + myImage.width
            + "px; height:" + myImage.height
            + "px;" + imgStyle + ";"
            + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
            + "(src=\'" + myImage.src + "\', sizingMethod='scale');\"></span>";
    myImage.outerHTML = strNewHTML;
  }
}

// Blur all windows if user clicks anywhere else on the page
document.addEvent('mousedown', function (event) {
  MUI.blurAll.delay(50);
});

window.addEvent('domready', function () {
  MUI.underlayInitialize();
});

window.addEvent('resize', function () {
  if ($('windowUnderlay')) {
    MUI.setUnderlaySize();
  }
  else {
    MUI.underlayInitialize();
  }
});

Element.implement({
  hide: function () {
    this.setStyle('display', 'none');
    return this;
  },
  show: function () {
    this.setStyle('display', 'block');
    return this;
  }
});

/*
 
 Shake effect by Uvumi Tools
 http://tools.uvumi.com/element-shake.html
 
 Function: shake
 
 Example:
 Shake a window.
 (start code)
 $('parametrics').shake()
 (end)
 
 */

Element.implement({
  shake: function (radius, duration) {
    radius = radius || 3;
    duration = duration || 500;
    duration = (duration / 50).toInt() - 1;
    var parent = this.getParent();
    if (parent != $(document.body) && parent.getStyle('position') == 'static') {
      parent.setStyle('position', 'relative');
    }
    var position = this.getStyle('position');
    if (position == 'static') {
      this.setStyle('position', 'relative');
      position = 'relative';
    }
    if (Browser.ie) {
      parent.setStyle('height', parent.getStyle('height'));
    }
    var coords = this.getPosition(parent);
    if (position == 'relative' && !Browser.opera) {
      coords.x -= parent.getStyle('paddingLeft').toInt();
      coords.y -= parent.getStyle('paddingTop').toInt();
    }
    var morph = this.retrieve('morph');
    if (morph) {
      morph.cancel();
      var oldOptions = morph.options;
    }
    var morph = this.get('morph', {
      duration: 50,
      link: 'chain'
    });
    for (var i = 0; i < duration; i++) {
      morph.start({
        /** 1.2
         top:coords.y+$random(-radius,radius),
         left:coords.x+$random(-radius,radius)
         */
        top: coords.y + Number.random(-radius, radius),
        left: coords.x + Number.random(-radius, radius)

      });
    }
    morph.start({
      top: coords.y,
      left: coords.x
    }).chain(function () {
      if (oldOptions) {
        this.set('morph', oldOptions);
      }
    }.bind(this));
    return this;
  }
});

String.implement({
  parseQueryString: function () {
    var vars = this.split(/[&;]/);
    var rs = {};
    if (vars.length)
      vars.each(function (val) {
        var keys = val.split('=');
        if (keys.length && keys.length == 2)
          rs[decodeURIComponent(keys[0])] = decodeURIComponent(keys[1]);
      });
    return rs;
  }

});

// Mootools Patch: Fixes issues in Safari, Chrome, and Internet Explorer caused by processing text as XML.
Request.HTML.implement({
  processHTML: function (text) {
    var match = text.match(/<body[^>]*>([\s\S]*?)<\/body>/i);
    text = (match) ? match[1] : text;
    var container = new Element('div');
    return container.set('html', text);
  }

});

/*
 
 Examples:
 (start code)
 getCSSRule('.myRule');
 getCSSRule('#myRule');
 (end)
 Nota: Alexis: Correción realizada debido a un error
 ReferenceError: assignment to undeclared variable i
 */
MUI.getCSSRule = function (selector) {
  for (var ii = 0; ii < document.styleSheets.length; ii++) {
    var mysheet = document.styleSheets[ii];
    var myrules = mysheet.cssRules ? mysheet.cssRules : mysheet.rules;
    for (var i = 0; i < myrules.length; i++) {
      if ((myrules[i].selectorText) && (myrules[i].selectorText == selector)) {
        return(myrules[i]);
      }
    }
  }
  return(false);
}

// This makes it so Request will work to some degree locally
if (location.protocol == "file:") {

  Request.implement({
    isSuccess: function (status) {
      return (status == 0 || (status >= 200) && (status < 300));
    }
  });

  Browser.Request = function () {
    /** 1.2 return $try(function(){ */
    return Function.attempt(function () {
      return new ActiveXObject('MSXML2.XMLHTTP');
    }, function () {
      return new XMLHttpRequest();
    });
  };

}


/** 1.2 $extend(Asset, { */
try {
  Object.append(Asset, {
    /* Fix an Opera bug in Mootools 1.2 */
    javascript: function (source, properties) {
      /** 1.2
       properties = $extend({
       //onload: $empty,
       document: document,
       check: $lambda(true)
       }, properties);
       **/
      properties = Object.append({
        onload: function () {
        },
        document: document,
        check: Function.from(true)
      }, properties);


      if ($(properties.id)) {
        properties.onload();
        return $(properties.id);
      }

      var script = new Element('script', {'src': source, 'type': 'text/javascript'});

      var load = properties.onload.bind(script), check = properties.check, doc = properties.document;
      delete properties.onload;
      delete properties.check;
      delete properties.document;

      /**  1.2 if (!Browser.firefox419 && !Browser.opera){ */
      if (!Browser.chrome && !Browser.opera) {
        script.addEvents({
          load: load,
          readystatechange: function () {
            if (Browser.ie && ['loaded', 'complete'].contains(this.readyState))
              load();
          }
        }).setProperties(properties);
      }
      else {
        var checker = (function () {
          /** 1.2 if (!$try(check)) return; **/
          if (!Function.attempt(check))
            return;

          /** 1.2 $clear(checker); */
          clearInterval(checker);
          // Opera has difficulty with multiple scripts being injected into the head simultaneously. We need to give it time to catch up.
          Browser.opera ? load.delay(500) : load();
        }).periodical(50);
      }
      return script.inject(doc.head);
    },
    // Get the CSS with XHR before appending it to document.head so that we can have an onload callback.
    css: function (source, properties) {
      /** 1.2
       properties = $extend({
       id: null,
       media: 'screen',
       //onload: $empty
       }, properties);
       **/
      properties = Object.append({
        id: null,
        media: 'screen',
        onload: function () {
        }
      }, properties);



      new Request({
        method: 'get',
        url: source,
        onComplete: function (response) {
          var newSheet = new Element('link', {
            'id': properties.id,
            'rel': 'stylesheet',
            'media': properties.media,
            'type': 'text/css',
            'href': source
          }).inject(document.head);
          properties.onload();
        }.bind(this),
        onFailure: function (response) {
        },
        onSuccess: function () {
        }.bind(this)
      }).send();
    }

  });
} catch (error) {
}

/*
 
 REGISTER PLUGINS
 
 Register Components and Plugins for Lazy Loading
 
 How this works may take a moment to grasp. Take a look at MUI.Window below.
 If we try to create a new Window and Window.js has not been loaded then the function
 below will run. It will load the CSS required by the MUI.Window Class and then
 then it will load Window.js. Here is the interesting part. When Window.js loads,
 it will overwrite the function below, and new MUI.Window(arg) will be ran
 again. This time it will create a new MUI.Window instance, and any future calls
 to new MUI.Window(arg) will immediately create new windows since the assets
 have already been loaded and our temporary function below has been overwritten.
 
 REGISTRO PLUGINS
 
   Registro Componentes y Plugins para Lazy Loading
 
   ¿Cómo funciona este pueden tomar un momento de captar. Echa un vistazo a MUI.Window continuación.
   Si tratamos de crear una nueva ventana y Window.js no se ha cargado entonces la función
   a continuación se ejecutará. Se carga el CSS requerida por la Clase MUI.Window y luego
   a continuación, se carga Window.js. Aquí está la parte interesante. Cuando cargas Window.js,
   sobrescribirá la función a continuación, y nueva MUI.Window (arg) se corrió
   de nuevo. Esta vez va a crear una nueva instancia MUI.Window, y cualquier llamada futura
   a la nueva MUI.Window (arg) creará inmediatamente nuevas ventanas ya los activos
   ya se han cargado y nuestra función temporal continuación se ha sobrescrito.
 
 
 
 Example:
 
 MyPlugins.extend({
 
 MyGadget: function(arg){
 new MUI.Require({
 css: [MUI.path.plugins + 'myGadget/css/style.css'],
 images: [MUI.path.plugins + 'myGadget/images/background.gif']
 js: [MUI.path.plugins + 'myGadget/scripts/myGadget.js'],
 onload: function(){
 new MyPlguins.MyGadget(arg);
 }
 });
 }
 
 });
 
 -------------------------------------------------------------------- */

//MUI.extend({

Object.append(MUI, {
  newWindowsFromJSON: function (arg) {
    new MUI.Require({
      js: [MUI.path.source + 'Window/Windows-from-json.js'],
      onload: function () {
        new MUI.newWindowsFromJSON(arg);
      }
    });
  },
  arrangeCascade: function () {
    new MUI.Require({
      js: [MUI.path.source + 'Window/Arrange-cascade.js'],
      onload: function () {
        new MUI.arrangeCascade();
      }
    });
  },
  arrangeTile: function () {
    new MUI.Require({
      js: [MUI.path.source + 'Window/Arrange-tile.js'],
      onload: function () {
        new MUI.arrangeTile();
      }
    });
  },
  saveWorkspace: function () {
    new MUI.Require({
      js: [MUI.path.source + 'Layout/Workspaces.js'],
      onload: function () {
        new MUI.saveWorkspace();
      }
    });
  },
  loadWorkspace: function () {
    new MUI.Require({
      js: [MUI.path.source + 'Layout/Workspaces.js'],
      onload: function () {
        new MUI.loadWorkspace();
      }
    });
  },
  Themes: {
    init: function (arg) {
      new MUI.Require({
        js: [MUI.path.source + 'Utilities/Themes.js'],
        onload: function () {
          MUI.Themes.init(arg);
        }
      });
    }
  }

});

Object.append(MUI, {
  /** Function: minimizeAll Minimize all windows that are minimizable. **/
  minimizeAll: function () {
    $$('.insside').each(function (windowEl) {
      var instance = windowEl.retrieve('instance');
      if (!instance.isMinimized && instance.options.minimizable == true) {
        MUI.Dock.minimizeWindow(windowEl);
      }
    }.bind(this));
  }
});

Object.append(MUI.options, {
  // Naming options:
  // If you change the IDs of the Insside Desktop containers in your HTML, you need to change them here as well.
  dockWrapper: 'dockWrapper',
  dock: 'dock'
});





/** Layout.js **/

/*
 arguments:
 column - The column to resize the panels in
 changing -  The panel that is collapsing, expanding, or new
 action - collapsing, expanding, or new
 
 */


function addResizeRight(element, min, max) {
  if (!$(element))
    return;
  element = $(element);
  /** 1.2 @todo */
  var instances = MUI.Columns.instances;
  var instance = instances.get(element.id);

  var handle = element.getNext('.columnHandle');
  handle.setStyle('cursor', Browser.firefox ? 'col-resize' : 'e-resize');
  if (!min)
    min = 50;
  if (!max)
    max = 250;
  if (Browser.ie) {
    handle.addEvents({
      'mousedown': function() {
        handle.setCapture();
      },
      'mouseup': function() {
        handle.releaseCapture();
      }
    });
  }
  /*** IEWIN8**/
  try {
    instance.resize = element.makeResizable({
      handle: handle,
      modifiers: {
        x: 'width',
        y: false
      },
      limit: {
        x: [min, max]
      },
      onStart: function() {
        element.getElements('iframe').setStyle('visibility', 'hidden');
        element.getNext('.column').getElements('iframe').setStyle('visibility', 'hidden');
      }.bind(this),
      onDrag: function() {
        if (Browser.firefox) {
          $$('.panel').each(function(panel) {
            if (panel.getElements('.inssideIframe').length == 0) {
              panel.hide(); // Fix for a rendering bug in FF
            }
          });
        }
        MUI.remainingWidth(element.getParent());
        if (Browser.firefox) {
          $$('.panel').show(); // Fix for a rendering bug in FF
        }
        if (Browser.ie4) {
          element.getChildren().each(function(el) {
            var width = $(element).getStyle('width').toInt();
            width -= el.getStyle('border-right').toInt();
            width -= el.getStyle('border-left').toInt();
            width -= el.getStyle('padding-right').toInt();
            width -= el.getStyle('padding-left').toInt();
            el.setStyle('width', width);
          }.bind(this));
        }
      }.bind(this),
      onComplete: function() {
        MUI.remainingWidth(element.getParent());
        element.getElements('iframe').setStyle('visibility', 'visible');
        element.getNext('.column').getElements('iframe').setStyle('visibility', 'visible');
        instance.fireEvent('onResize');
      }.bind(this)
    });
  } catch (error) {
  }
}

function addResizeLeft(element, min, max) {
  if (!$(element))
    return;
  element = $(element);
  /** 1.2 @todo */
  var instances = MUI.Columns.instances;
  var instance = instances.get(element.id);

  var handle = element.getPrevious('.columnHandle');
  handle.setStyle('cursor', Browser.firefox ? 'col-resize' : 'e-resize');
  var partner = element.getPrevious('.column');
  if (!min)
    min = 50;
  if (!max)
    max = 250;
  if (Browser.ie) {
    handle.addEvents({
      'mousedown': function() {
        handle.setCapture();
      },
      'mouseup': function() {
        handle.releaseCapture();
      }
    });
  }
  /** IEWIN8**/
  try {
    instance.resize = element.makeResizable({
      handle: handle,
      modifiers: {x: 'width', y: false},
      invert: true,
      limit: {x: [min, max]},
      onStart: function() {
        $(element).getElements('iframe').setStyle('visibility', 'hidden');
        partner.getElements('iframe').setStyle('visibility', 'hidden');
      }.bind(this),
      onDrag: function() {
        MUI.remainingWidth(element.getParent());
      }.bind(this),
      onComplete: function() {
        MUI.remainingWidth(element.getParent());
        $(element).getElements('iframe').setStyle('visibility', 'visible');
        partner.getElements('iframe').setStyle('visibility', 'visible');
        instance.fireEvent('onResize');
      }.bind(this)
    });
  } catch (error) {
  }
}

function addResizeBottom(element) {
  if (!$(element))
    return;
  var element = $(element);
  /** 1.2 @todo */
  var instances = MUI.Panels.instances;
  var instance = instances.get(element.id);
  var handle = instance.handleEl;
  handle.setStyle('cursor', Browser.firefox ? 'row-resize' : 'n-resize');
  var partner = instance.partner;
  var min = 0;
  var max = function() {
    return element.getStyle('height').toInt() + partner.getStyle('height').toInt();
  }.bind(this);

  if (Browser.ie) {
    handle.addEvents({
      'mousedown': function() {
        handle.setCapture();
      },
      'mouseup': function() {
        handle.releaseCapture();
      }
    });
  }
  try {
    instance.resize = element.makeResizable({
      handle: handle,
      modifiers: {x: false, y: 'height'},
      limit: {y: [min, max]},
      invert: false,
      onBeforeStart: function() {
        partner = instance.partner;
        this.originalHeight = element.getStyle('height').toInt();
        this.partnerOriginalHeight = partner.getStyle('height').toInt();
      }.bind(this),
      onStart: function() {
        if (instance.iframeEl) {
          if (!Browser.ie) {
            instance.iframeEl.setStyle('visibility', 'hidden');
            partner.getElements('iframe').setStyle('visibility', 'hidden');
          }
          else {
            instance.iframeEl.hide();
            partner.getElements('iframe').hide();
          }
        }

      }.bind(this),
      onDrag: function() {
        partnerHeight = partnerOriginalHeight;
        partnerHeight += (this.originalHeight - element.getStyle('height').toInt());
        partner.setStyle('height', partnerHeight);
        MUI.resizeChildren(element, element.getStyle('height').toInt());
        MUI.resizeChildren(partner, partnerHeight);
        element.getChildren('.column').each(function(column) {
          MUI.panelHeight(column);
        });
        partner.getChildren('.column').each(function(column) {
          MUI.panelHeight(column);
        });
      }.bind(this),
      onComplete: function() {
        partnerHeight = partnerOriginalHeight;
        partnerHeight += (this.originalHeight - element.getStyle('height').toInt());
        partner.setStyle('height', partnerHeight);
        MUI.resizeChildren(element, element.getStyle('height').toInt());
        MUI.resizeChildren(partner, partnerHeight);
        element.getChildren('.column').each(function(column) {
          MUI.panelHeight(column);
        });
        partner.getChildren('.column').each(function(column) {
          MUI.panelHeight(column);
        });
        if (instance.iframeEl) {
          if (!Browser.ie) {
            instance.iframeEl.setStyle('visibility', 'visible');
            partner.getElements('iframe').setStyle('visibility', 'visible');
          }
          else {
            instance.iframeEl.show();
            partner.getElements('iframe').show();
            // The following hack is to get IE8 Standards Mode to properly resize an iframe
            // when only the vertical dimension is changed.
            var width = instance.iframeEl.getStyle('width').toInt();
            instance.iframeEl.setStyle('width', width - 1);
            MUI.remainingWidth();
            instance.iframeEl.setStyle('width', width);
          }
        }
        instance.fireEvent('onResize');
      }.bind(this)
    });
  } catch (error) {
  }
}


//MUI.extend({
Object.append(MUI, {
  /*
   
   Function: closeColumn
   Destroys/removes a column.
   
   Syntax:
   (start code)
   MUI.closeColumn();
   (end)
   
   Arguments:
   columnEl - the ID of the column to be closed
   
   Returns:
   true - the column was closed
   false - the column was not closed
   
   */
  closeColumn: function(columnEl) {
    /** 1.2 @todo */
    var instances = MUI.Columns.instances;
    var instance = instances.get(columnEl.id);
    if (columnEl != $(columnEl) || instance.isClosing)
      return;

    instance.isClosing = true;

    if (instance.options.sortable) {
      instance.container.retrieve('sortables').removeLists(this.columnEl);
    }

    // Destroy all the panels in the column.
    var panels = columnEl.getChildren('.panel');
    panels.each(function(panel) {
      MUI.closePanel($(panel.id));
    }.bind(this));

    if (Browser.ie) {
      columnEl.dispose();
      if (instance.handleEl != null) {
        instance.handleEl.dispose();
      }
    }
    else {
      columnEl.destroy();
      if (instance.handleEl != null) {
        instance.handleEl.destroy();
      }
    }
    if (MUI.Desktop) {
      MUI.Desktop.resizePanels();
    }
    /** 1.2 @todo */
    instances.erase(instance.options.id);
    return true;
  },
  /*
   
   Function: closePanel
   Destroys/removes a panel.
   
   Syntax:
   (start code)
   MUI.closePanel();
   (end)
   
   Arguments:
   panelEl - the ID of the panel to be closed
   
   Returns:
   true - the panel was closed
   false - the panel was not closed
   
   */
  closePanel: function(panelEl) {
    /** 1.2 @todo */
    var instances = MUI.Panels.instances;
    var instance = instances.get(panelEl.id);
    if (panelEl != $(panelEl) || instance.isClosing)
      return;

    var column = instance.options.column;

    instance.isClosing = true;
    /** 1.2 @todo */
    var columnInstances = MUI.Columns.instances;
    var columnInstance = columnInstances.get(column);

    if (columnInstance.options.sortable) {
      columnInstance.options.container.retrieve('sortables').removeItems(instance.panelWrapperEl);
    }

    instance.panelWrapperEl.destroy();

    if (MUI.Desktop) {
      MUI.Desktop.resizePanels();
    }

    // Do this when creating and removing panels
    $(column).getChildren('.panelWrapper').each(function(panelWrapper) {
      panelWrapper.getElement('.panel').removeClass('bottomPanel');
    });
    $(column).getChildren('.panelWrapper').getLast().getElement('.panel').addClass('bottomPanel');
    /** 1.2 @todo */
    instances.erase(instance.options.id);
    return true;

  },
  titlePanel: function(panelEl,titulo){
    var instance =panelEl.retrieve('instance');
    instance.titleEl.set('html', titulo);
  },
});




/*

Script: Workspaces.js
	Save and load workspaces. The Workspaces emulate Adobe Illustrator functionality remembering what windows are open and where they are positioned.

Copyright:
	Copyright (c) 20010-2020 Jose Alexis Correa Valencia , <http://www.insside.com/>.

License:
	MIT-style license.

Requires:
	Core.js, Window.js

To do:
	- Move to Window

    Changes from Mootools 1.2 to 1.4.x  , 2013 no compat <http://www.domenacom.hr/>
    darko.hajnal@domenacom.hr 

*/

MUI.files[MUI.path.source + 'Layout/Workspaces.js'] = 'loaded';

//MUI.extend({
Object.append( MUI, {    
	/*
	
	Function: saveWorkspace
		Save the current workspace.
	
	Syntax:
	(start code)
		MUI.saveWorkspace();
	(end)
	
	Notes:
		This version saves the ID of each open window to a cookie, and reloads those windows using the functions in insside-init.js. 
This requires that each window have a function in insside-init.js used to open them. 
Functions must be named the windowID + "Window". So if your window is called mywindow, it needs a function called mywindowWindow in insside-init.js.
	
	*/
	saveWorkspace: function(){
		this.cookie =new Hash.Cookie('inssideUIworkspaceCookie', {duration: 3600});
		this.cookie.empty();
                /** 1.2 */
		//MUI.Windows.instances.each(function(instance) {
                Object.each( MUI.Windows.instances, function(instance){ 
			instance.saveValues();
			this.cookie.set(instance.options.id, {
				'id': instance.options.id,
				'top': instance.options.y,
				'left': instance.options.x,
				'width': instance.contentWrapperEl.getStyle('width').toInt(),
				'height': instance.contentWrapperEl.getStyle('height').toInt()
			});
		}.bind(this));
		this.cookie.save();

		new MUI.Window({
			loadMethod: 'html',
			type: 'notification',
			addClass: 'notification',
			content: 'Workspace saved.',
			closeAfter: '1400',
			width: 200,
			height: 40,
			y: 53,
			padding:  { top: 10, right: 12, bottom: 10, left: 12 },
			shadowBlur: 5,
			bodyBgColor: [255, 255, 255]
		});
		
	},
	windowUnload: function(){
		if ($$('.insside').length == 0 && this.myChain){
			this.myChain.callChain();
		}		
	},
	loadWorkspace2: function(workspaceWindows){		
		workspaceWindows.each(function(workspaceWindow){				
			windowFunction = eval('MUI.' + workspaceWindow.id + 'Window');
			if (windowFunction){
				eval('MUI.' + workspaceWindow.id + 'Window({width:'+ workspaceWindow.width +',height:' + workspaceWindow.height + '});');
				var windowEl = $(workspaceWindow.id);
				windowEl.setStyles({
					'top': workspaceWindow.top,
					'left': workspaceWindow.left
				});
				var instance = windowEl.retrieve('instance');
				instance.contentWrapperEl.setStyles({
					'width': workspaceWindow.width,
					'height': workspaceWindow.height
				});
				instance.drawWindow();
			}
		}.bind(this));
		this.loadingWorkspace = false;
	},
	/*

	Function: loadWorkspace
		Load the saved workspace.

	Syntax:
	(start code)
		MUI.loadWorkspace();
	(end)

	*/
	loadWorkspace: function(){
		cookie =new Hash.Cookie('inssideUIworkspaceCookie', {duration: 3600});
		workspaceWindows = cookie.load();

		if(!cookie.getKeys().length){
			new MUI.Window({
				loadMethod: 'html',
				type: 'notification',
				addClass: 'notification',
				content: 'You have no saved workspace.',
				closeAfter: '1400',
				width: 220,
				height: 40,
				y: 25,
				padding:  { top: 10, right: 12, bottom: 10, left: 12 },
				shadowBlur: 5,
				bodyBgColor: [255, 255, 255]
			});
			return;
		}

		if ($$('.insside').length != 0){
			this.loadingWorkspace = true;
			this.myChain =new Chain();
			this.myChain.chain(
				function(){
					$$('.insside').each(function(el) {
						this.closeWindow(el);
					}.bind(this));
				}.bind(this),
				function(){
					this.loadWorkspace2(workspaceWindows);
				}.bind(this)
			);
			this.myChain.callChain();
		}
		else {
			this.loadWorkspace2(workspaceWindows);
		}

	}
});



/*
 Script: Window.js
 Build windows.
 Copyright:
 Copyright (c) 2013 Jose Alexis Correa Valencia, <jalexiscv@gmail.com>.
 License:
 MIT-style license.
 Requires:
 Core.js
 */

//$require(MUI.themePath() + '/css/Dock.css');
/*
 Class: Window
 Creates a single InssideUI window.
 
 Syntax:
 (start code)
 new MUI.Window(options);
 (end)
 
 Arguments:
 options
 
 Options:
 id - The ID of the window. If not defined, it will be set to 'win' + windowIDCount.
 title - The title of the window.
 icon - Place an icon in the window's titlebar. This is either set to false or to the url of the icon. It is set up for icons that are 16 x 16px.
 type - ('window', 'modal', 'modal2', or 'notification') Defaults to 'window'. Modals should be created with new MUI.Modal(options).
 loadMethod - ('html', 'xhr', or 'iframe') Defaults to 'html' if there is no contentURL. Defaults to 'xhr' if there is a contentURL. You only really need to set this if using the 'iframe' method.
 contentURL - Used if loadMethod is set to 'xhr' or 'iframe'.
 closeAfter - Either false or time in milliseconds. Closes the window after a certain period of time in milliseconds. This is particularly useful for notifications.
 evalScripts - (boolean) An xhr loadMethod option. Defaults to true.
 evalResponse - (boolean) An xhr loadMethod option. Defaults to false.
 content - (string or element) An html loadMethod option.
 toolbar - (boolean) Create window toolbar. Defaults to false. This can be used for tabs, media controls, and so forth.
 toolbarPosition - ('top' or 'bottom') Defaults to top.
 toolbarHeight - (number)
 toolbarURL - (url) Defaults to 'pages/lipsum.html'.
 toolbarContent - (string)
 toolbarOnload - (function)
 toolbar2 - (boolean) Create window toolbar. Defaults to false. This can be used for tabs, media controls, and so forth.
 toolbar2Position - ('top' or 'bottom') Defaults to top.
 toolbar2Height - (number)
 toolbar2URL - (url) Defaults to 'pages/lipsum.html'.
 toolbar2Content - (string)
 toolbar2Onload - (function)
 container - (element ID) Element the window is injected in. The container defaults to 'desktop'. If no desktop then to document.body. Use 'pageWrapper' if you don't want the windows to overlap the toolbars.
 restrict - (boolean) Restrict window to container when dragging.
 shape - ('box' or 'gauge') Shape of window. Defaults to 'box'.
 collapsible - (boolean) Defaults to true.
 minimizable - (boolean) Requires MUI.Desktop and MUI.Dock. Defaults to true if dependenices are met.
 maximizable - (boolean) Requires MUI.Desktop. Defaults to true if dependenices are met.
 closable - (boolean) Defaults to true.
 storeOnClose - (boolean) Hides a window and it's dock tab rather than destroying them on close. If you try to create the window again it will unhide the window and dock tab.
 modalOverlayClose - (boolean) Whether or not you can close a modal by clicking on the modal overlay. Defaults to true.
 draggable - (boolean) Defaults to false for modals; otherwise true.
 draggableGrid - (false or number) Distance in pixels for snap-to-grid dragging. Defaults to false.
 draggableLimit - (false or number) An object with x and y properties used to limit the movement of the Window. Defaults to false.
 draggableSnap - (boolean) The distance to drag before the Window starts to respond to the drag. Defaults to false.
 resizable - (boolean) Defaults to false for modals, notifications and gauges; otherwise true.
 resizeLimit - (object) Minimum and maximum width and height of window when resized.
 addClass - (string) Add a class to the window for more control over styling.
 width - (number) Width of content area.
 height - (number) Height of content area.
 headerHeight - (number) Height of window titlebar.
 footerHeight - (number) Height of window footer.
 cornerRadius - (number)
 x - (number) If x and y are left undefined the window is centered on the page.
 y - (number)
 scrollbars - (boolean)
 padding - (object)
 shadowBlur - (number) Width of shadows.
 shadowOffset - Should be positive and not be greater than the ShadowBlur.
 controlsOffset - Change this if you want to reposition the window controls.
 useCanvas - (boolean) Set this to false if you don't want a canvas body.
 useCanvasControls - (boolean) Set this to false if you wish to use images for the buttons.
 useSpinner - (boolean) Toggles whether or not the ajax spinners are displayed in window footers. Defaults to true.
 headerStartColor - ([r,g,b,]) Titlebar gradient's top color
 headerStopColor - ([r,g,b,]) Titlebar gradient's bottom color
 bodyBgColor - ([r,g,b,]) Background color of the main canvas shape
 minimizeBgColor - ([r,g,b,]) Minimize button background color
 minimizeColor - ([r,g,b,]) Minimize button color
 maximizeBgColor - ([r,g,b,]) Maximize button background color
 maximizeColor - ([r,g,b,]) Maximize button color
 closeBgColor - ([r,g,b,]) Close button background color
 closeColor - ([r,g,b,]) Close button color
 resizableColor - ([r,g,b,]) Resizable icon color
 onBeforeBuild - (function) Fired just before the window is built.
 onContentLoaded - (function) Fired when content is successfully loaded via XHR or Iframe.
 onFocus - (function)  Fired when the window is focused.
 onBlur - (function) Fired when window loses focus.
 onResize - (function) Fired when the window is resized.
 onMinimize - (function) Fired when the window is minimized.
 onMaximize - (function) Fired when the window is maximized.
 onRestore - (function) Fired when a window is restored from minimized or maximized.
 onClose - (function) Fired just before the window is closed.
 onCloseComplete - (function) Fired after the window is closed.
 
 Returns:
 Window object.
 
 Example:
 Define a window. It is suggested you name the function the same as your window ID + "Window".
 (start code)
 var mywindowWindow = function(){
 new MUI.Window({
 id: 'mywindow',
 title: 'My Window',
 loadMethod: 'xhr',
 contentURL: 'pages/lipsum.html',
 width: 340,
 height: 150
 });
 }
 (end)
 
 Example:
 Create window onDomReady.
 (start code)
 window.addEvent('domready', function(){
 mywindow();
 });
 (end)
 
 Example:
 Add link events to build future windows. It is suggested you give your anchor the same ID as your window + "WindowLink" or + "WindowLinkCheck". Use the latter if it is a link in the menu toolbar.
 
 If you wish to add links in windows that open other windows remember to add events to those links when the windows are created.
 
 (start code)
 // Javascript:
 if ($('mywindowLink')){
 $('mywindowLink').addEvent('click', function(e) {
 e.stop();
 mywindow();
 });
 }
 
 // HTML:
 <a id="mywindowLink" href="pages/lipsum.html">My Window</a>
 (end)
 
 
 Loading Content with an XMLHttpRequest(xhr):
 For content to load via xhr all the files must be online and in the same domain. If you need to load content from another domain or wish to have it work offline, load the content in an iframe instead of using the xhr option.
 
 Iframes:
 If you use the iframe loadMethod your iframe will automatically be resized when the window it is in is resized. If you want this same functionality when using one of the other load options simply add class="inssideIframe" to those iframes and they will be resized for you as well.
 
 */
// Having these options outside of the Class allows us to add, change, and remove
// individual options without rewriting all of them.
/**
 MUI.extend({
 Windows: {
 instances:      new Hash(),
 indexLevel:     100,          // Used for window z-Index
 windowIDCount:  0,            // Used for windows without an ID defined by the user
 windowsVisible: true,         // Ctrl-Alt-Q to toggle window visibility
 focusingWindow: false
 }
 });
 **/
Object.append(MUI, {
  Windows: {
    /** 1.2 @todo */
    instances: new Hash(),
    //instances: new Object(),

    indexLevel: 100, // Used for window z-Index
    windowIDCount: 0, // Used for windows without an ID defined by the user
    windowsVisible: true, // Ctrl-Alt-Q to toggle window visibility
    focusingWindow: false
  }
});
MUI.Windows.windowOptions = {
  id: null,
  title: 'New Window',
  icon: false,
  type: 'window',
  require: {
    css: [],
    images: [],
    js: [],
    onload: null
  },
  loadMethod: null,
  method: 'get',
  contentURL: null,
  data: null,
  closeAfter: false,
  // xhr options
  evalScripts: true,
  evalResponse: false,
  // html options
  content: 'Window content',
  // Toolbar
  toolbar: false,
  toolbarPosition: 'top',
  toolbarHeight: 29,
  toolbarURL: 'pages/lipsum.html',
  toolbarData: null,
  toolbarContent: '',
  toolbarOnload: function () {
  },
  // Toolbar
  toolbar2: false,
  toolbar2Position: 'bottom',
  toolbar2Height: 29,
  toolbar2URL: 'pages/lipsum.html',
  toolbar2Data: null,
  toolbar2Content: '',
  toolbar2Onload: function () {
  },
  // Container options
  container: null,
  restrict: true,
  shape: 'box',
  // Window Controls
  collapsible: true,
  minimizable: true,
  maximizable: true,
  closable: true,
  // Close options
  storeOnClose: false,
  // Modal options
  modalOverlayClose: true,
  // Draggable
  draggable: null,
  draggableGrid: false,
  draggableLimit: false,
  draggableSnap: false,
  // Resizable
  resizable: null,
  resizeLimit: {
    'x': [250, 2500],
    'y': [125, 2000]
  },
  // Style options:
  addClass: '',
  width: 300,
  height: 125,
  headerHeight: 25,
  footerHeight: 25,
  cornerRadius: 8,
  x: null,
  y: null,
  scrollbars: false,
  padding: {
    top: 10,
    right: 12,
    bottom: 10,
    left: 12
  },
  shadowBlur: 5,
  shadowOffset: {
    'x': 0,
    'y': 1
  },
  controlsOffset: {
    'right': 6,
    'top': 6
  },
  useCanvas: true,
  useCanvasControls: true,
  useSpinner: true,
  // Color options:
  headerStartColor: [250, 250, 250],
  headerStopColor: [229, 229, 229],
  bodyBgColor: [229, 229, 229],
  minimizeBgColor: [255, 255, 255],
  minimizeColor: [0, 0, 0],
  maximizeBgColor: [255, 255, 255],
  maximizeColor: [0, 0, 0],
  closeBgColor: [255, 255, 255],
  closeColor: [0, 0, 0],
  resizableColor: [254, 254, 254],
  // Events
  onBeforeBuild: function () {
  },
  onContentLoaded: function () {
  },
  onFocus: function () {
  },
  onBlur: function () {
  },
  onResize: function () {
  },
  onMinimize: function () {
  },
  onMaximize: function () {
  },
  onRestore: function () {
  },
  onClose: function () {
  },
  onCloseComplete: function () {
  }
};
/** 1.2 @todo check this is not in use */
//MUI.Windows.windowOptionsOriginal = $merge(MUI.Windows.windowOptions);
MUI.Window = new Class({
  Implements: [Events, Options],
  options: MUI.Windows.windowOptions,
  initialize: function (options) {
    this.setOptions(options);

    // Shorten object chain
    var options = this.options;

    /** 1.2  */
    //$extend(this, {
    Object.append(this, {
      inssideControlsWidth: 0,
      minimizebuttonX: 0, // Minimize button horizontal position
      maximizebuttonX: 0, // Maximize button horizontal position
      closebuttonX: 0, // Close button horizontal position
      headerFooterShadow: options.headerHeight + options.footerHeight + (options.shadowBlur * 2),
      oldTop: 0,
      oldLeft: 0,
      isMaximized: false,
      isMinimized: false,
      isCollapsed: false,
      timestamp: Date.now()
    });



    if (options.type != 'window') {
      options.container = document.body;
      options.minimizable = false;
    }

    if (!options.container) {
      options.container = MUI.Desktop && MUI.Desktop.desktop ? MUI.Desktop.desktop : document.body;
    }

    // Set this.options.resizable to default if it was not defined
    if (options.resizable == null) {
      if (options.type != 'window' || options.shape == 'gauge') {
        options.resizable = false;
      } else {
        options.resizable = true;
      }
    }

    // Set this.options.draggable if it was not defined
    if (options.draggable == null) {
      options.draggable = options.type != 'window' ? false : true;
    }

    // Gauges are not maximizable or resizable
    if (options.shape == 'gauge' || options.type == 'notification') {
      options.collapsible = false;
      options.maximizable = false;
      options.contentBgColor = 'transparent';
      options.scrollbars = false;
      options.footerHeight = 0;
    }
    if (options.type == 'notification') {
      options.closable = false;
      options.headerHeight = 0;
    }

    // Minimizable, dock is required and window cannot be modal
    if (MUI.Dock && $(MUI.options.dock)) {
      if (MUI.Dock.dock && options.type != 'modal' && options.type != 'modal2') {
        options.minimizable = options.minimizable;
      }
    } else {
      options.minimizable = false;
    }

    // Maximizable, desktop is required
    options.maximizable = MUI.Desktop && MUI.Desktop.desktop && options.maximizable && options.type != 'modal' && options.type != 'modal2';

    if (this.options.type == 'modal2') {
      this.options.shadowBlur = 0;
      this.options.shadowOffset = {
        'x': 0,
        'y': 0
      };
      this.options.useSpinner = false;
      this.options.useCanvas = false;
      this.options.footerHeight = 0;
      this.options.headerHeight = 0;
    }

    // If window has no ID, give it one.
    options.id = options.id || 'win' + (++MUI.Windows.windowIDCount);

    this.windowEl = $(options.id);


    if (options.require.css.length || options.require.images.length) {
      new MUI.Require({
        css: options.require.css,
        images: options.require.images,
        onload: function () {
          this.newWindow();
        }.bind(this)
      });
    } else {
      this.newWindow();
    }

    // Return window object
    return this;
  },
  saveValues: function () {
    var coordinates = this.windowEl.getCoordinates();
    this.options.x = coordinates.left.toInt();
    this.options.y = coordinates.top.toInt();
  },
  /*
   
   Internal Function: newWindow
   
   Arguments:
   properties
   
   */
  newWindow: function (properties) { // options is not doing anything

    var instances = MUI.Windows.instances;
    /** @todo 1.2 BUG Hash.get */
    var instanceID = MUI.Windows.instances.get(this.options.id);

    //if ( MUI.Windows.instances.options) {
    //    var instanceID = MUI.Windows.instances.options.id;
    //}
    var options = this.options;

    // Here we check to see if there is already a class instance for this window
    if (instanceID)
      var instance = instanceID;

    // Check if window already exists and is not in progress of closing
    if (this.windowEl && !this.isClosing) {
      // Restore if minimized
      if (instance.isMinimized) {
        MUI.Dock.restoreMinimized(this.windowEl);
      }
      // Expand and focus if collapsed
      else if (instance.isCollapsed) {
        MUI.collapseToggle(this.windowEl);
        setTimeout(MUI.focusWindow.pass(this.windowEl, this), 10);
      } else if (this.windowEl.hasClass('windowClosed')) {

        if (instance.check)
          instance.check.show();

        this.windowEl.removeClass('windowClosed');
        this.windowEl.setStyle('opacity', 0);
        this.windowEl.addClass('insside');

        if (MUI.Dock && $(MUI.options.dock) && instance.options.type == 'window') {
          var currentButton = $(instance.options.id + '_dockTab');
          if (currentButton != null) {
            currentButton.show();
          }
          MUI.Desktop.setDesktopSize();
        }

        instance.displayNewWindow();

      }
      // Else focus
      else {
        var coordinates = document.getCoordinates();
        if (this.windowEl.getStyle('left').toInt() > coordinates.width || this.windowEl.getStyle('top').toInt() > coordinates.height) {
          MUI.centerWindow(this.windowEl);
        }
        setTimeout(MUI.focusWindow.pass(this.windowEl, this), 10);
        if (MUI.options.standardEffects == true) {
          this.windowEl.shake();
        }
      }
      return;
    } else {
      /** 1.2 @todo */
      instances.set(options.id, this);
      //Object.merge(instances , this);

    }

    this.isClosing = false;
    this.fireEvent('onBeforeBuild');

    // Create window div
    MUI.Windows.indexLevel++;
    this.windowEl = new Element('div', {
      'class': 'insside',
      'id': options.id,
      'styles': {
        'position': 'absolute',
        'width': options.width,
        'height': options.height,
        'display': 'block',
        'opacity': 0,
        'zIndex': MUI.Windows.indexLevel += 2
      }
    });

    this.windowEl.store('instance', this);

    this.windowEl.addClass(options.addClass);

    if (options.type == 'modal2') {
      this.windowEl.addClass('modal2');
    }

    // Fix a mouseover issue with gauges in IE7
    if (Browser.ie && options.shape == 'gauge') {
      this.windowEl.setStyle('backgroundImage', 'url(../images/spacer.gif)');
    }

    if ((this.options.type == 'modal' || options.type == 'modal2') && Browser.Platform.mac && Browser.firefox) {
      if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
        var ffversion = new Number(RegExp.$1);
        if (ffversion < 3) {
          this.windowEl.setStyle('position', 'fixed');
        }
      }
    }

    if (options.loadMethod == 'iframe') {
      options.padding = {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
      };
    }

    // Insert sub elements inside windowEl
    this.insertWindowElements();

    // Set title
    this.titleEl.set('html', options.title);

    this.contentWrapperEl.setStyle('overflow', 'hidden');

    this.contentEl.setStyles({
      'padding-top': options.padding.top,
      'padding-bottom': options.padding.bottom,
      'padding-left': options.padding.left,
      'padding-right': options.padding.right
    });

    if (options.shape == 'gauge') {
      if (options.useCanvasControls) {
        this.canvasControlsEl.setStyle('visibility', 'hidden');
      } else {
        this.controlsEl.setStyle('visibility', 'hidden');
      }
      this.windowEl.addEvent('mouseover', function () {
        this.mouseover = true;
        var showControls = function () {
          if (this.mouseover != false) {
            if (options.useCanvasControls) {
              this.canvasControlsEl.setStyle('visibility', 'visible');
            } else {
              this.controlsEl.setStyle('visibility', 'visible');
            }
            this.canvasHeaderEl.setStyle('visibility', 'visible');
            this.titleEl.show();
          }
        };
        showControls.delay(0, this);

      }.bind(this));
      this.windowEl.addEvent('mouseleave', function () {
        this.mouseover = false;
        if (this.options.useCanvasControls) {
          this.canvasControlsEl.setStyle('visibility', 'hidden');
        } else {
          this.controlsEl.setStyle('visibility', 'hidden');
        }
        this.canvasHeaderEl.setStyle('visibility', 'hidden');
        this.titleEl.hide();
      }.bind(this));
    }

    // Inject window into DOM
    this.windowEl.inject(options.container);

    // Convert CSS colors to Canvas colors.
    this.setColors();

    if (options.type != 'notification') {
      this.setInssideControlsWidth();
    }

    // Add content to window.
    MUI.updateContent({
      'element': this.windowEl,
      'content': options.content,
      'method': options.method,
      'url': options.contentURL,
      'data': options.data,
      'onContentLoaded': null,
      'require': {
        js: options.require.js,
        onload: options.require.onload
      }
    });

    // Add content to window toolbar.
    if (this.options.toolbar == true) {
      MUI.updateContent({
        'element': this.windowEl,
        'childElement': this.toolbarEl,
        'content': options.toolbarContent,
        'loadMethod': 'xhr',
        'method': options.method,
        'url': options.toolbarURL,
        'data': options.toolbarData,
        'onContentLoaded': options.toolbarOnload
      });
    }

    // Add content to window toolbar.
    if (this.options.toolbar2 == true) {
      MUI.updateContent({
        'element': this.windowEl,
        'childElement': this.toolbar2El,
        'content': options.toolbar2Content,
        'loadMethod': 'xhr',
        'method': options.method,
        'url': options.toolbar2URL,
        'data': options.toolbar2Data,
        'onContentLoaded': options.toolbar2Onload
      });
    }

    this.drawWindow();

    // Attach events to the window
    this.attachDraggable();
    this.attachResizable();
    this.setupEvents();

    if (options.resizable) {
      this.adjustHandles();
    }

    // Position window. If position not specified by user then center the window on the page.
    if (options.container == document.body || options.container == MUI.Desktop.desktop) {
      var dimensions = window.getSize();
    } else {
      var dimensions = $(this.options.container).getSize();
    }

    if (!options.y) {
      if (MUI.Desktop && MUI.Desktop.desktop) {
        var y = (dimensions.y * .5) - (this.windowEl.offsetHeight * .5);
        if (y < -options.shadowBlur)
          y = -options.shadowBlur;
      } else {
        var y = window.getScroll().y + (window.getSize().y * .5) - (this.windowEl.offsetHeight * .5);
        if (y < -options.shadowBlur)
          y = -options.shadowBlur;
      }
    } else {
      var y = options.y - options.shadowBlur;
    }

    if (!this.options.x) {
      var x = (dimensions.x * .5) - (this.windowEl.offsetWidth * .5);
      if (x < -options.shadowBlur)
        x = -options.shadowBlur;
    } else {
      var x = options.x - options.shadowBlur;
    }

    this.windowEl.setStyles({
      'top': y,
      'left': x
    });

    // Create opacityMorph

    this.opacityMorph = new Fx.Morph(this.windowEl, {
      'duration': 350,
      transition: Fx.Transitions.Sine.easeInOut,
      onComplete: function () {
        if (Browser.ie) {
          this.drawWindow();
        }
      }.bind(this)
    });

    this.displayNewWindow();

    // This is a generic morph that can be reused later by functions like centerWindow()
    // It returns the windowEl element rather than this Class.
    this.morph = new Fx.Morph(this.windowEl, {
      'duration': 200
    });
    this.windowEl.store('morph', this.morph);
    try {
      this.resizeMorph = new Fx.Elements([this.contentWrapperEl, this.windowEl], {
        duration: 400,
        transition: Fx.Transitions.Sine.easeInOut,
        onStart: function () {
          this.resizeAnimation = this.drawWindow.periodical(20, this);
        }.bind(this),
        onComplete: function () {
          $clear(this.resizeAnimation);
          this.drawWindow();
          // Show iframe
          if (this.iframeEl) {
            this.iframeEl.setStyle('visibility', 'visible');
          }
        }.bind(this)
      });
      this.windowEl.store('resizeMorph', this.resizeMorph);
    } catch (error) {
    }
    // Add check mark to menu if link exists in menu
    // Need to make sure the check mark is not added to links not in menu
    if ($(this.windowEl.id + 'LinkCheck')) {
      this.check = new Element('div', {
        'class': 'check',
        'id': this.options.id + '_check'
      }).inject(this.windowEl.id + 'LinkCheck');
    }

    if (this.options.closeAfter != false) {
      MUI.closeWindow.delay(this.options.closeAfter, this, this.windowEl);
    }

    if (MUI.Dock && $(MUI.options.dock) && this.options.type == 'window') {
      MUI.Dock.createDockTab(this.windowEl);
    }

  },
  displayNewWindow: function () {

    options = this.options;
    if (options.type == 'modal' || options.type == 'modal2') {
      MUI.currentModal = this.windowEl;
      if (Browser.ie4) {
        $('modalFix').show();
      }
      $('modalOverlay').show();
      if (MUI.options.advancedEffects == false) {
        $('modalOverlay').setStyle('opacity', .95);
        this.windowEl.setStyles({
          'zIndex': 11000,
          'opacity': 1
        });
      } else {
        MUI.Modal.modalOverlayCloseMorph.cancel();
        MUI.Modal.modalOverlayOpenMorph.start({
          'opacity': .95
        });
        this.windowEl.setStyles({
          'zIndex': 11000
        });
        this.opacityMorph.start({
          'opacity': 1
        });
      }

      $$('.dockTab').removeClass('activeDockTab');
      $$('.insside').removeClass('isFocused');
      this.windowEl.addClass('isFocused');

    } else if (MUI.options.advancedEffects == false) {
      this.windowEl.setStyle('opacity', 1);
      setTimeout(MUI.focusWindow.pass(this.windowEl, this), 10);
    } else {
      // IE cannot handle both element opacity and VML alpha at the same time.
      if (Browser.ie) {
        this.drawWindow(false);
      }
      this.opacityMorph.start({
        'opacity': 1
      });
      setTimeout(MUI.focusWindow.pass(this.windowEl, this), 10);
    }

  },
  setupEvents: function () {
    var windowEl = this.windowEl;
    // Set events
    // Note: if a button does not exist, its due to properties passed to newWindow() stating otherwice
    if (this.closeButtonEl) {
      this.closeButtonEl.addEvent('click', function (e) {
        e.stop();
        MUI.closeWindow(windowEl);
      }.bind(this));
    }

    if (this.options.type == 'window') {
      windowEl.addEvent('mousedown', function (e) {
        if (Browser.ie) {
          e.stop();
        }
        MUI.focusWindow(windowEl);
        if (windowEl.getStyle('top').toInt() < -this.options.shadowBlur) {
          windowEl.setStyle('top', -this.options.shadowBlur);
        }
      }.bind(this));
    }

    if (this.minimizeButtonEl) {
      this.minimizeButtonEl.addEvent('click', function (e) {
        e.stop();
        MUI.Dock.minimizeWindow(windowEl);
      }.bind(this));
    }

    if (this.maximizeButtonEl) {
      this.maximizeButtonEl.addEvent('click', function (e) {
        e.stop();
        if (this.isMaximized) {
          MUI.Desktop.restoreWindow(windowEl);
        } else {
          MUI.Desktop.maximizeWindow(windowEl);
        }
      }.bind(this));
    }

    if (this.options.collapsible == true) {
      // Keep titlebar text from being selected on double click in Safari.
      this.titleEl.addEvent('selectstart', function (e) {
        e.stop();
      }.bind(this));

      if (Browser.ie) {
        this.titleBarEl.addEvent('mousedown', function (e) {
          this.titleEl.setCapture();
        }.bind(this));
        this.titleBarEl.addEvent('mouseup', function (e) {
          this.titleEl.releaseCapture();
        }.bind(this));
      }

      this.titleBarEl.addEvent('dblclick', function (e) {
        e.stop();
        MUI.collapseToggle(this.windowEl);
      }.bind(this));
    }

  },
  /*
   
   Internal Function: attachDraggable()
   Make window draggable.
   
   */
  attachDraggable: function () {
    var windowEl = this.windowEl;
    if (!this.options.draggable)
      return;
    this.windowDrag = new Drag.Move(windowEl, {
      handle: this.titleBarEl,
      container: this.options.restrict == true ? $(this.options.container) : false,
      grid: this.options.draggableGrid,
      limit: this.options.draggableLimit,
      snap: this.options.draggableSnap,
      onStart: function () {
        if (this.options.type != 'modal' && this.options.type != 'modal2') {
          MUI.focusWindow(windowEl);
          $('windowUnderlay').show();
        }
        if (this.iframeEl) {
          if (!Browser.ie) {
            this.iframeEl.setStyle('visibility', 'hidden');
          } else {
            this.iframeEl.hide();
          }
        }
      }.bind(this),
      onComplete: function () {
        if (this.options.type != 'modal' && this.options.type != 'modal2') {
          $('windowUnderlay').hide();
        }
        if (this.iframeEl) {
          if (!Browser.ie) {
            this.iframeEl.setStyle('visibility', 'visible');
          } else {
            this.iframeEl.show();
          }
        }
        // Store new position in options.
        this.saveValues();
      }.bind(this)
    });
  },
  /*
   
   Internal Function: attachResizable
   Make window resizable.
   
   */
  attachResizable: function () {
    var windowEl = this.windowEl;
    if (!this.options.resizable)
      return;
    this.resizable1 = this.windowEl.makeResizable({
      handle: [this.n, this.ne, this.nw],
      limit: {
        y: [
          function () {
            return this.windowEl.getStyle('top').toInt() + this.windowEl.getStyle('height').toInt() - this.options.resizeLimit.y[1];
          }.bind(this),
          function () {
            return this.windowEl.getStyle('top').toInt() + this.windowEl.getStyle('height').toInt() - this.options.resizeLimit.y[0];
          }.bind(this)
        ]
      },
      modifiers: {
        x: false,
        y: 'top'
      },
      onStart: function () {
        this.resizeOnStart();
        this.coords = this.contentWrapperEl.getCoordinates();
        this.y2 = this.coords.top.toInt() + this.contentWrapperEl.offsetHeight;
      }.bind(this),
      onDrag: function () {
        this.coords = this.contentWrapperEl.getCoordinates();
        this.contentWrapperEl.setStyle('height', this.y2 - this.coords.top.toInt());
        this.resizeOnDrag();
      }.bind(this),
      onComplete: function () {
        this.resizeOnComplete();
      }.bind(this)
    });

    this.resizable2 = this.contentWrapperEl.makeResizable({
      handle: [this.e, this.ne],
      limit: {
        x: [this.options.resizeLimit.x[0] - (this.options.shadowBlur * 2), this.options.resizeLimit.x[1] - (this.options.shadowBlur * 2)]
      },
      modifiers: {
        x: 'width',
        y: false
      },
      onStart: function () {
        this.resizeOnStart();
      }.bind(this),
      onDrag: function () {
        this.resizeOnDrag();
      }.bind(this),
      onComplete: function () {
        this.resizeOnComplete();
      }.bind(this)
    });

    this.resizable3 = this.contentWrapperEl.makeResizable({
      container: this.options.restrict == true ? $(this.options.container) : false,
      handle: this.se,
      limit: {
        x: [this.options.resizeLimit.x[0] - (this.options.shadowBlur * 2), this.options.resizeLimit.x[1] - (this.options.shadowBlur * 2)],
        y: [this.options.resizeLimit.y[0] - this.headerFooterShadow, this.options.resizeLimit.y[1] - this.headerFooterShadow]
      },
      modifiers: {
        x: 'width',
        y: 'height'
      },
      onStart: function () {
        this.resizeOnStart();
      }.bind(this),
      onDrag: function () {
        this.resizeOnDrag();
      }.bind(this),
      onComplete: function () {
        this.resizeOnComplete();
      }.bind(this)
    });

    this.resizable4 = this.contentWrapperEl.makeResizable({
      handle: [this.s, this.sw],
      limit: {
        y: [this.options.resizeLimit.y[0] - this.headerFooterShadow, this.options.resizeLimit.y[1] - this.headerFooterShadow]
      },
      modifiers: {
        x: false,
        y: 'height'
      },
      onStart: function () {
        this.resizeOnStart();
      }.bind(this),
      onDrag: function () {
        this.resizeOnDrag();
      }.bind(this),
      onComplete: function () {
        this.resizeOnComplete();
      }.bind(this)
    });

    this.resizable5 = this.windowEl.makeResizable({
      handle: [this.w, this.sw, this.nw],
      limit: {
        x: [
          function () {
            return this.windowEl.getStyle('left').toInt() + this.windowEl.getStyle('width').toInt() - this.options.resizeLimit.x[1];
          }.bind(this),
          function () {
            return this.windowEl.getStyle('left').toInt() + this.windowEl.getStyle('width').toInt() - this.options.resizeLimit.x[0];
          }.bind(this)
        ]
      },
      modifiers: {
        x: 'left',
        y: false
      },
      onStart: function () {
        this.resizeOnStart();
        this.coords = this.contentWrapperEl.getCoordinates();
        this.x2 = this.coords.left.toInt() + this.contentWrapperEl.offsetWidth;
      }.bind(this),
      onDrag: function () {
        this.coords = this.contentWrapperEl.getCoordinates();
        this.contentWrapperEl.setStyle('width', this.x2 - this.coords.left.toInt());
        this.resizeOnDrag();
      }.bind(this),
      onComplete: function () {
        this.resizeOnComplete();
      }.bind(this)
    });

  },
  resizeOnStart: function () {
    $('windowUnderlay').show();
    if (this.iframeEl) {
      if (!Browser.ie) {
        this.iframeEl.setStyle('visibility', 'hidden');
      } else {
        this.iframeEl.hide();
      }
    }
  },
  resizeOnDrag: function () {
    // Fix for a rendering glitch in FF when resizing a window with panels in it
    if (Browser.firefox) {
      this.windowEl.getElements('.panel').each(function (panel) {
        panel.store('oldOverflow', panel.getStyle('overflow'));
        panel.setStyle('overflow', 'visible');
      });
    }
    this.drawWindow();
    this.adjustHandles();
    if (Browser.firefox) {
      this.windowEl.getElements('.panel').each(function (panel) {
        panel.setStyle('overflow', panel.retrieve('oldOverflow')); // Fix for a rendering bug in FF
      });
    }
  },
  resizeOnComplete: function () {
    $('windowUnderlay').hide();
    if (this.iframeEl) {
      if (!Browser.ie) {
        this.iframeEl.setStyle('visibility', 'visible');
      } else {
        this.iframeEl.show();
        // The following hack is to get IE8 RC1 IE8 Standards Mode to properly resize an iframe
        // when only the vertical dimension is changed.
        this.iframeEl.setStyle('width', '99%');
        this.iframeEl.setStyle('height', this.contentWrapperEl.offsetHeight);
        this.iframeEl.setStyle('width', '100%');
        this.iframeEl.setStyle('height', this.contentWrapperEl.offsetHeight);
      }
    }

    // Resize panels if there are any
    if (this.contentWrapperEl.getChildren('.column') != null) {
      MUI.remainingWidth(this.contentWrapperEl);
      this.contentWrapperEl.getChildren('.column').each(function (column) {
        MUI.panelHeight(column);
      });
    }

    this.fireEvent('onResize', this.windowEl);
  },
  adjustHandles: function () {

    var shadowBlur = this.options.shadowBlur;
    var shadowBlur2x = shadowBlur * 2;
    var shadowOffset = this.options.shadowOffset;
    var top = shadowBlur - shadowOffset.y - 1;
    var right = shadowBlur + shadowOffset.x - 1;
    var bottom = shadowBlur + shadowOffset.y - 1;
    var left = shadowBlur - shadowOffset.x - 1;

    var coordinates = this.windowEl.getCoordinates();
    var width = coordinates.width - shadowBlur2x + 2;
    var height = coordinates.height - shadowBlur2x + 2;

    this.n.setStyles({
      'top': top,
      'left': left + 10,
      'width': width - 20
    });
    this.e.setStyles({
      'top': top + 10,
      'right': right,
      'height': height - 30
    });
    this.s.setStyles({
      'bottom': bottom,
      'left': left + 10,
      'width': width - 30
    });
    this.w.setStyles({
      'top': top + 10,
      'left': left,
      'height': height - 20
    });
    this.ne.setStyles({
      'top': top,
      'right': right
    });
    this.se.setStyles({
      'bottom': bottom,
      'right': right
    });
    this.sw.setStyles({
      'bottom': bottom,
      'left': left
    });
    this.nw.setStyles({
      'top': top,
      'left': left
    });
  },
  detachResizable: function () {
    this.resizable1.detach();
    this.resizable2.detach();
    this.resizable3.detach();
    this.resizable4.detach();
    this.resizable5.detach();
    this.windowEl.getElements('.handle').hide();
  },
  reattachResizable: function () {
    this.resizable1.attach();
    this.resizable2.attach();
    this.resizable3.attach();
    this.resizable4.attach();
    this.resizable5.attach();
    this.windowEl.getElements('.handle').show();
  },
  /*
   
   Internal Function: insertWindowElements
   
   Arguments:
   windowEl
   
   */
  insertWindowElements: function () {

    var options = this.options;
    var height = options.height;
    var width = options.width;
    var id = options.id;

    var cache = {};

    if (Browser.ie4) {
      cache.zIndexFixEl = new Element('iframe', {
        'id': id + '_zIndexFix',
        'class': 'zIndexFix',
        'scrolling': 'no',
        'marginWidth': 0,
        'marginHeight': 0,
        'src': '',
        'styles': {
          'position': 'absolute' // This is set here to make theme transitions smoother
        }
      }).inject(this.windowEl);
    }

    cache.overlayEl = new Element('div', {
      'id': id + '_overlay',
      'class': 'inssideOverlay',
      'styles': {
        'position': 'absolute', // This is set here to make theme transitions smoother
        'top': 0,
        'left': 0
      }
    }).inject(this.windowEl);

    cache.titleBarEl = new Element('div', {
      'id': id + '_titleBar',
      'class': 'inssideTitlebar',
      'styles': {
        'cursor': options.draggable ? 'move' : 'default'
      }
    }).inject(cache.overlayEl, 'top');

    cache.titleEl = new Element('h3', {
      'id': id + '_title',
      'class': 'inssideTitle'
    }).inject(cache.titleBarEl);

    if (options.icon != false) {
      cache.titleEl.setStyles({
        'padding-left': 28,
        'background': 'url(' + options.icon + ') 5px 4px no-repeat'
      });
    }

    cache.contentBorderEl = new Element('div', {
      'id': id + '_contentBorder',
      'class': 'inssideContentBorder'
    }).inject(cache.overlayEl);

    if (options.toolbar) {
      cache.toolbarWrapperEl = new Element('div', {
        'id': id + '_toolbarWrapper',
        'class': 'inssideToolbarWrapper',
        'styles': {
          'height': options.toolbarHeight
        }
      }).inject(cache.contentBorderEl, options.toolbarPosition == 'bottom' ? 'after' : 'before');

      if (options.toolbarPosition == 'bottom') {
        cache.toolbarWrapperEl.addClass('bottom');
      }
      cache.toolbarEl = new Element('div', {
        'id': id + '_toolbar',
        'class': 'inssideToolbar',
        'styles': {
          'height': options.toolbarHeight
        }
      }).inject(cache.toolbarWrapperEl);
    }

    if (options.toolbar2) {
      cache.toolbar2WrapperEl = new Element('div', {
        'id': id + '_toolbar2Wrapper',
        'class': 'inssideToolbarWrapper',
        'styles': {
          'height': options.toolbar2Height
        }
      }).inject(cache.contentBorderEl, options.toolbar2Position == 'bottom' ? 'after' : 'before');

      if (options.toolbar2Position == 'bottom') {
        cache.toolbar2WrapperEl.addClass('bottom');
      }
      cache.toolbar2El = new Element('div', {
        'id': id + '_toolbar2',
        'class': 'inssideToolbar',
        'styles': {
          'height': options.toolbar2Height
        }
      }).inject(cache.toolbar2WrapperEl);
    }

    cache.contentWrapperEl = new Element('div', {
      'id': id + '_contentWrapper',
      'class': 'inssideContentWrapper',
      'styles': {
        'width': width + 'px',
        'height': height + 'px'
      }
    }).inject(cache.contentBorderEl);

    if (this.options.shape == 'gauge') {
      cache.contentBorderEl.setStyle('borderemainingWidth', 0);
    }

    cache.contentEl = new Element('div', {
      'id': id + '_content',
      'class': 'inssideContent'
    }).inject(cache.contentWrapperEl);

    if (this.options.useCanvas == true && Browser.ie != true) {
      cache.canvasEl = new Element('canvas', {
        'id': id + '_canvas',
        'class': 'inssideCanvas',
        'width': 10,
        'height': 10
      }).inject(this.windowEl);
    }

    if (this.options.useCanvas == true && Browser.ie) {
      cache.canvasEl = new Element('canvas', {
        'id': id + '_canvas',
        'class': 'inssideCanvas',
        'width': 50000, // IE8 excanvas requires these large numbers
        'height': 20000,
        'styles': {
          'position': 'absolute',
          'top': 0,
          'left': 0
        }
      }).inject(this.windowEl);

      if (MUI.ieSupport == 'excanvas') {
        G_vmlCanvasManager.initElement(cache.canvasEl);
        cache.canvasEl = this.windowEl.getElement('.inssideCanvas');
      }
    }

    cache.controlsEl = new Element('div', {
      'id': id + '_controls',
      'class': 'inssideControls'
    }).inject(cache.overlayEl, 'after');

    if (options.useCanvasControls == true) {
      cache.canvasControlsEl = new Element('canvas', {
        'id': id + '_canvasControls',
        'class': 'inssideCanvasControls',
        'width': 14,
        'height': 14
      }).inject(this.windowEl);

      if (Browser.ie && MUI.ieSupport == 'excanvas') {
        G_vmlCanvasManager.initElement(cache.canvasControlsEl);
        cache.canvasControlsEl = this.windowEl.getElement('.inssideCanvasControls');
      }
    }

    if (options.closable) {
      cache.closeButtonEl = new Element('div', {
        'id': id + '_closeButton',
        'class': 'inssideCloseButton inssideWindowButton',
        'title': 'Close'
      }).inject(cache.controlsEl);
    }

    if (options.maximizable) {
      cache.maximizeButtonEl = new Element('div', {
        'id': id + '_maximizeButton',
        'class': 'inssideMaximizeButton inssideWindowButton',
        'title': 'Maximize'
      }).inject(cache.controlsEl);
    }

    if (options.minimizable) {
      cache.minimizeButtonEl = new Element('div', {
        'id': id + '_minimizeButton',
        'class': 'inssideMinimizeButton inssideWindowButton',
        'title': 'Minimize'
      }).inject(cache.controlsEl);
    }
    if (options.useSpinner == true && options.shape != 'gauge' && options.type != 'notification') {
      cache.spinnerEl = new Element('div', {
        'id': id + '_spinner',
        'class': 'inssideSpinner',
        'width': 16,
        'height': 16
      }).inject(this.windowEl, 'bottom');
    }

    if (this.options.shape == 'gauge') {
      cache.canvasHeaderEl = new Element('canvas', {
        'id': id + '_canvasHeader',
        'class': 'inssideCanvasHeader',
        'width': this.options.width,
        'height': 26
      }).inject(this.windowEl, 'bottom');
      if (Browser.ie && MUI.ieSupport == 'excanvas') {
        G_vmlCanvasManager.initElement(cache.canvasHeaderEl);
        cache.canvasHeaderEl = this.windowEl.getElement('.inssideCanvasHeader');
      }
    }

    if (Browser.ie) {
      cache.overlayEl.setStyle('zIndex', 2);
    }

    // For Mac Firefox 2 to help reduce scrollbar bugs in that browser
    if (Browser.Platform.mac && Browser.firefox) {
      if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
        var ffversion = new Number(RegExp.$1);
        if (ffversion < 3) {
          cache.overlayEl.setStyle('overflow', 'auto');
        }
      }
    }

    if (options.resizable) {
      cache.n = new Element('div', {
        'id': id + '_resizeHandle_n',
        'class': 'handle',
        'styles': {
          'top': 0,
          'left': 10,
          'cursor': 'n-resize'
        }
      }).inject(cache.overlayEl, 'after');

      cache.ne = new Element('div', {
        'id': id + '_resizeHandle_ne',
        'class': 'handle corner',
        'styles': {
          'top': 0,
          'right': 0,
          'cursor': 'ne-resize'
        }
      }).inject(cache.overlayEl, 'after');

      cache.e = new Element('div', {
        'id': id + '_resizeHandle_e',
        'class': 'handle',
        'styles': {
          'top': 10,
          'right': 0,
          'cursor': 'e-resize'
        }
      }).inject(cache.overlayEl, 'after');

      cache.se = new Element('div', {
        'id': id + '_resizeHandle_se',
        'class': 'handle cornerSE',
        'styles': {
          'bottom': 0,
          'right': 0,
          'cursor': 'se-resize'
        }
      }).inject(cache.overlayEl, 'after');

      cache.s = new Element('div', {
        'id': id + '_resizeHandle_s',
        'class': 'handle',
        'styles': {
          'bottom': 0,
          'left': 10,
          'cursor': 's-resize'
        }
      }).inject(cache.overlayEl, 'after');

      cache.sw = new Element('div', {
        'id': id + '_resizeHandle_sw',
        'class': 'handle corner',
        'styles': {
          'bottom': 0,
          'left': 0,
          'cursor': 'sw-resize'
        }
      }).inject(cache.overlayEl, 'after');

      cache.w = new Element('div', {
        'id': id + '_resizeHandle_w',
        'class': 'handle',
        'styles': {
          'top': 10,
          'left': 0,
          'cursor': 'w-resize'
        }
      }).inject(cache.overlayEl, 'after');

      cache.nw = new Element('div', {
        'id': id + '_resizeHandle_nw',
        'class': 'handle corner',
        'styles': {
          'top': 0,
          'left': 0,
          'cursor': 'nw-resize'
        }
      }).inject(cache.overlayEl, 'after');
    }
    /** 1.2 */
    //$extend(this, cache);
    Object.append(this, cache);

  },
  /*
   
   Convert CSS colors to Canvas colors.
   
   */
  setColors: function () {

    if (this.options.useCanvas == true) {

      // Set TitlebarColor
      var pattern = /\?(.*?)\)/;
      if (this.titleBarEl.getStyle('backgroundImage') != 'none') {
        var gradient = this.titleBarEl.getStyle('backgroundImage');
        gradient = gradient.match(pattern)[1];
        gradient = gradient.parseQueryString();
        var gradientFrom = gradient.from;
        var gradientTo = gradient.to.replace(/\"/, ''); // IE7 was adding a quotation mark in. No idea why.
        try {
          this.options.headerStartColor = new Color(gradientFrom);
          this.options.headerStopColor = new Color(gradientTo);
        } catch (error) {
        }
        this.titleBarEl.addClass('replaced');
      } else if (this.titleBarEl.getStyle('background-color') !== '' && this.titleBarEl.getStyle('background-color') !== 'transparent') {
        try {
          this.options.headerStartColor = new Color(this.titleBarEl.getStyle('background-color')).mix('#fff', 20);
          this.options.headerStopColor = new Color(this.titleBarEl.getStyle('background-color')).mix('#000', 20);
        } catch (error) {
        }
        this.titleBarEl.addClass('replaced');
      }

      // Set BodyBGColor
      if (this.windowEl.getStyle('background-color') !== '' && this.windowEl.getStyle('background-color') !== 'transparent') {
        try {
          this.options.bodyBgColor = new Color(this.windowEl.getStyle('background-color'));
        } catch (error) {
        }
        this.windowEl.addClass('replaced');
      }

      // Set resizableColor, the color of the SE corner resize handle
      if (this.options.resizable && this.se.getStyle('background-color') !== '' && this.se.getStyle('background-color') !== 'transparent') {
        try {
          this.options.resizableColor = new Color(this.se.getStyle('background-color'));
        } catch (error) {
        }
        this.se.addClass('replaced');
      }

    }

    if (this.options.useCanvasControls == true) {

      if (this.minimizeButtonEl) {

        // Set Minimize Button Foreground Color
        if (this.minimizeButtonEl.getStyle('color') !== '' && this.minimizeButtonEl.getStyle('color') !== 'transparent') {
          try {
            this.options.minimizeColor = new Color(this.minimizeButtonEl.getStyle('color'));
          } catch (error) {
          }
        }

        // Set Minimize Button Background Color
        if (this.minimizeButtonEl.getStyle('background-color') !== '' && this.minimizeButtonEl.getStyle('background-color') !== 'transparent') {
          try {
            this.options.minimizeBgColor = new Color(this.minimizeButtonEl.getStyle('background-color'));
          } catch (error) {
          }
          this.minimizeButtonEl.addClass('replaced');
        }

      }

      if (this.maximizeButtonEl) {

        // Set Maximize Button Foreground Color
        if (this.maximizeButtonEl.getStyle('color') !== '' && this.maximizeButtonEl.getStyle('color') !== 'transparent') {
          try {
            this.options.maximizeColor = new Color(this.maximizeButtonEl.getStyle('color'));
          } catch (error) {
          }
        }

        // Set Maximize Button Background Color
        if (this.maximizeButtonEl.getStyle('background-color') !== '' && this.maximizeButtonEl.getStyle('background-color') !== 'transparent') {
          try {
            this.options.maximizeBgColor = new Color(this.maximizeButtonEl.getStyle('background-color'));
          } catch (error) {
          }
          this.maximizeButtonEl.addClass('replaced');
        }

      }

      if (this.closeButtonEl) {

        // Set Close Button Foreground Color
        if (this.closeButtonEl.getStyle('color') !== '' && this.closeButtonEl.getStyle('color') !== 'transparent') {
          try {
            this.options.closeColor = new Color(this.closeButtonEl.getStyle('color'));
          } catch (error) {
          }
        }

        // Set Close Button Background Color
        if (this.closeButtonEl.getStyle('background-color') !== '' && this.closeButtonEl.getStyle('background-color') !== 'transparent') {
          try {
            this.options.closeBgColor = new Color(this.closeButtonEl.getStyle('background-color'));
          } catch (error) {
          }
          this.closeButtonEl.addClass('replaced');
        }

      }
    }
  },
  /*
   
   Internal function: drawWindow
   This is where we create the canvas GUI
   
   Arguments:
   windowEl: the $(window)
   shadows: (boolean) false will draw a window without shadows
   
   */
  drawWindow: function (shadows) {

    if (this.drawingWindow == true)
      return;
    this.drawingWindow = true;

    if (this.isCollapsed) {
      this.drawWindowCollapsed(shadows);
      return;
    }

    var windowEl = this.windowEl;

    var options = this.options;
    var shadowBlur = options.shadowBlur;
    var shadowBlur2x = shadowBlur * 2;
    var shadowOffset = this.options.shadowOffset;

    this.overlayEl.setStyles({
      'width': this.contentWrapperEl.offsetWidth
    });

    // Resize iframe when window is resized
    if (this.iframeEl) {
      this.iframeEl.setStyle('height', this.contentWrapperEl.offsetHeight);
    }

    var borderHeight = this.contentBorderEl.getStyle('border-top').toInt() + this.contentBorderEl.getStyle('border-bottom').toInt();
    var toolbarHeight = this.toolbarWrapperEl ? this.toolbarWrapperEl.getStyle('height').toInt() + this.toolbarWrapperEl.getStyle('border-top').toInt() : 0;
    var toolbar2Height = this.toolbar2WrapperEl ? this.toolbar2WrapperEl.getStyle('height').toInt() + this.toolbar2WrapperEl.getStyle('border-top').toInt() : 0;

    this.headerFooterShadow = options.headerHeight + options.footerHeight + shadowBlur2x;
    var height = this.contentWrapperEl.getStyle('height').toInt() + this.headerFooterShadow + toolbarHeight + toolbar2Height + borderHeight;
    var width = this.contentWrapperEl.getStyle('width').toInt() + shadowBlur2x;
    this.windowEl.setStyles({
      'height': height,
      'width': width
    });

    this.overlayEl.setStyles({
      'height': height,
      'top': shadowBlur - shadowOffset.y,
      'left': shadowBlur - shadowOffset.x
    });

    if (this.options.useCanvas == true) {
      if (Browser.ie) {
        this.canvasEl.height = 20000;
        this.canvasEl.width = 50000;
      }
      this.canvasEl.height = height;
      this.canvasEl.width = width;
    }

    // Part of the fix for IE6 select z-index bug
    if (Browser.ie4) {
      this.zIndexFixEl.setStyles({
        'width': width,
        'height': height
      })
    }

    this.titleBarEl.setStyles({
      'width': width - shadowBlur2x,
      'height': options.headerHeight
    });

    // Make sure loading icon is placed correctly.
    if (options.useSpinner == true && options.shape != 'gauge' && options.type != 'notification') {
      this.spinnerEl.setStyles({
        'left': shadowBlur - shadowOffset.x + 3,
        'bottom': shadowBlur + shadowOffset.y + 4
      });
    }

    if (this.options.useCanvas != false) {

      // Draw Window
      var ctx = this.canvasEl.getContext('2d');
      ctx.clearRect(0, 0, width, height);

      switch (options.shape) {
        case 'box':
          this.drawBox(ctx, width, height, shadowBlur, shadowOffset, shadows);
          break;
        case 'gauge':
          this.drawGauge(ctx, width, height, shadowBlur, shadowOffset, shadows);
          break;
      }

      if (options.resizable) {
        MUI.triangle(
                ctx,
                width - (shadowBlur + shadowOffset.x + 17),
                height - (shadowBlur + shadowOffset.y + 18),
                11,
                11,
                options.resizableColor,
                1.0
                );
      }

      // Invisible dummy object. The last element drawn is not rendered consistently while resizing in IE6 and IE7
      if (Browser.ie) {
        MUI.triangle(ctx, 0, 0, 10, 10, options.resizableColor, 0);
      }
    }

    if (options.type != 'notification' && options.useCanvasControls == true) {
      this.drawControls(width, height, shadows);
    }

    // Resize panels if there are any
    if (MUI.Desktop && this.contentWrapperEl.getChildren('.column').length != 0) {
      MUI.remainingWidth(this.contentWrapperEl);
      this.contentWrapperEl.getChildren('.column').each(function (column) {
        MUI.panelHeight(column);
      });
    }

    this.drawingWindow = false;
    return this;

  },
  drawWindowCollapsed: function (shadows) {

    var windowEl = this.windowEl;

    var options = this.options;
    var shadowBlur = options.shadowBlur;
    var shadowBlur2x = shadowBlur * 2;
    var shadowOffset = options.shadowOffset;

    var headerShadow = options.headerHeight + shadowBlur2x + 2;
    var height = headerShadow;
    var width = this.contentWrapperEl.getStyle('width').toInt() + shadowBlur2x;
    this.windowEl.setStyle('height', height);

    this.overlayEl.setStyles({
      'height': height,
      'top': shadowBlur - shadowOffset.y,
      'left': shadowBlur - shadowOffset.x
    });

    // Part of the fix for IE6 select z-index bug
    if (Browser.ie4) {
      this.zIndexFixEl.setStyles({
        'width': width,
        'height': height
      });
    }

    // Set width
    this.windowEl.setStyle('width', width);
    this.overlayEl.setStyle('width', width);
    this.titleBarEl.setStyles({
      'width': width - shadowBlur2x,
      'height': options.headerHeight
    });

    // Draw Window
    if (this.options.useCanvas != false) {
      this.canvasEl.height = height;
      this.canvasEl.width = width;

      var ctx = this.canvasEl.getContext('2d');
      ctx.clearRect(0, 0, width, height);

      this.drawBoxCollapsed(ctx, width, height, shadowBlur, shadowOffset, shadows);
      if (options.useCanvasControls == true) {
        this.drawControls(width, height, shadows);
      }

      // Invisible dummy object. The last element drawn is not rendered consistently while resizing in IE6 and IE7
      if (Browser.ie) {
        MUI.triangle(ctx, 0, 0, 10, 10, options.resizableColor, 0);
      }
    }

    this.drawingWindow = false;
    return this;

  },
  drawControls: function (width, height, shadows) {
    var options = this.options;
    var shadowBlur = options.shadowBlur;
    var shadowOffset = options.shadowOffset;
    var controlsOffset = options.controlsOffset;

    // Make sure controls are placed correctly.
    this.controlsEl.setStyles({
      'right': shadowBlur + shadowOffset.x + controlsOffset.right,
      'top': shadowBlur - shadowOffset.y + controlsOffset.top
    });

    this.canvasControlsEl.setStyles({
      'right': shadowBlur + shadowOffset.x + controlsOffset.right,
      'top': shadowBlur - shadowOffset.y + controlsOffset.top
    });

    // Calculate X position for controlbuttons
    //var inssideControlsWidth = 52;
    this.closebuttonX = options.closable ? this.inssideControlsWidth - 7 : this.inssideControlsWidth + 12;
    this.maximizebuttonX = this.closebuttonX - (options.maximizable ? 19 : 0);
    this.minimizebuttonX = this.maximizebuttonX - (options.minimizable ? 19 : 0);

    var ctx2 = this.canvasControlsEl.getContext('2d');
    ctx2.clearRect(0, 0, 100, 100);

    if (this.options.closable) {
      this.closebutton(
              ctx2,
              this.closebuttonX,
              7,
              options.closeBgColor,
              1.0,
              options.closeColor,
              1.0
              );
    }
    if (this.options.maximizable) {
      this.maximizebutton(
              ctx2,
              this.maximizebuttonX,
              7,
              options.maximizeBgColor,
              1.0,
              options.maximizeColor,
              1.0
              );
    }
    if (this.options.minimizable) {
      this.minimizebutton(
              ctx2,
              this.minimizebuttonX,
              7,
              options.minimizeBgColor,
              1.0,
              options.minimizeColor,
              1.0
              );
    }
    // Invisible dummy object. The last element drawn is not rendered consistently while resizing in IE6 and IE7
    if (Browser.ie) {
      MUI.circle(ctx2, 0, 0, 3, this.options.resizableColor, 0);
    }

  },
  drawBox: function (ctx, width, height, shadowBlur, shadowOffset, shadows) {

    var options = this.options;
    var shadowBlur2x = shadowBlur * 2;
    var cornerRadius = this.options.cornerRadius;

    // This is the drop shadow. It is created onion style.
    if (shadows != false) {
      for (var x = 0; x <= shadowBlur; x++) {
        MUI.roundedRect(
                ctx,
                shadowOffset.x + x,
                shadowOffset.y + x,
                width - (x * 2) - shadowOffset.x,
                height - (x * 2) - shadowOffset.y,
                cornerRadius + (shadowBlur - x), [0, 0, 0],
                x == shadowBlur ? .29 : .065 + (x * .01)
                );
      }
    }
    // Window body.
    this.bodyRoundedRect(
            ctx, // context
            shadowBlur - shadowOffset.x, // x
            shadowBlur - shadowOffset.y, // y
            width - shadowBlur2x, // width
            height - shadowBlur2x, // height
            cornerRadius, // corner radius
            options.bodyBgColor // Footer color
            );

    if (this.options.type != 'notification') {
      // Window header.
      this.topRoundedRect(
              ctx, // context
              shadowBlur - shadowOffset.x, // x
              shadowBlur - shadowOffset.y, // y
              width - shadowBlur2x, // width
              options.headerHeight, // height
              cornerRadius, // corner radius
              options.headerStartColor, // Header gradient's top color
              options.headerStopColor // Header gradient's bottom color
              );
    }
  },
  drawBoxCollapsed: function (ctx, width, height, shadowBlur, shadowOffset, shadows) {

    var options = this.options;
    var shadowBlur2x = shadowBlur * 2;
    var cornerRadius = options.cornerRadius;

    // This is the drop shadow. It is created onion style.
    if (shadows != false) {
      for (var x = 0; x <= shadowBlur; x++) {
        MUI.roundedRect(
                ctx,
                shadowOffset.x + x,
                shadowOffset.y + x,
                width - (x * 2) - shadowOffset.x,
                height - (x * 2) - shadowOffset.y,
                cornerRadius + (shadowBlur - x), [0, 0, 0],
                x == shadowBlur ? .3 : .06 + (x * .01)
                );
      }
    }

    // Window header
    this.topRoundedRect2(
            ctx, // context
            shadowBlur - shadowOffset.x, // x
            shadowBlur - shadowOffset.y, // y
            width - shadowBlur2x, // width
            options.headerHeight + 2, // height
            cornerRadius, // corner radius
            options.headerStartColor, // Header gradient's top color
            options.headerStopColor // Header gradient's bottom color
            );

  },
  drawGauge: function (ctx, width, height, shadowBlur, shadowOffset, shadows) {
    var options = this.options;
    var radius = (width * .5) - (shadowBlur) + 16;
    if (shadows != false) {
      for (var x = 0; x <= shadowBlur; x++) {
        MUI.circle(
                ctx,
                width * .5 + shadowOffset.x, (height + options.headerHeight) * .5 + shadowOffset.x, (width * .5) - (x * 2) - shadowOffset.x, [0, 0, 0],
                x == shadowBlur ? .75 : .075 + (x * .04)
                );
      }
    }
    MUI.circle(
            ctx,
            width * .5 - shadowOffset.x, (height + options.headerHeight) * .5 - shadowOffset.y, (width * .5) - shadowBlur,
            options.bodyBgColor,
            1
            );

    // Draw gauge header
    this.canvasHeaderEl.setStyles({
      'top': shadowBlur - shadowOffset.y,
      'left': shadowBlur - shadowOffset.x
    });
    var ctx = this.canvasHeaderEl.getContext('2d');
    ctx.clearRect(0, 0, width, 100);
    ctx.beginPath();
    ctx.lineWidth = 24;
    ctx.lineCap = 'round';
    ctx.moveTo(13, 13);
    ctx.lineTo(width - (shadowBlur * 2) - 13, 13);
    ctx.strokeStyle = 'rgba(0, 0, 0, .65)';
    ctx.stroke();
  },
  bodyRoundedRect: function (ctx, x, y, width, height, radius, rgb) {
    ctx.fillStyle = 'rgba(' + rgb.join(',') + ', 1)';
    ctx.beginPath();
    ctx.moveTo(x, y + radius);
    ctx.lineTo(x, y + height - radius);
    ctx.quadraticCurveTo(x, y + height, x + radius, y + height);
    ctx.lineTo(x + width - radius, y + height);
    ctx.quadraticCurveTo(x + width, y + height, x + width, y + height - radius);
    ctx.lineTo(x + width, y + radius);
    ctx.quadraticCurveTo(x + width, y, x + width - radius, y);
    ctx.lineTo(x + radius, y);
    ctx.quadraticCurveTo(x, y, x, y + radius);
    ctx.fill();

  },
  topRoundedRect: function (ctx, x, y, width, height, radius, headerStartColor, headerStopColor) {
    var lingrad = ctx.createLinearGradient(0, 0, 0, height);
    lingrad.addColorStop(0, 'rgb(' + headerStartColor.join(',') + ')');
    lingrad.addColorStop(1, 'rgb(' + headerStopColor.join(',') + ')');
    ctx.fillStyle = lingrad;
    ctx.beginPath();
    ctx.moveTo(x, y);
    ctx.lineTo(x, y + height);
    ctx.lineTo(x + width, y + height);
    ctx.lineTo(x + width, y + radius);
    ctx.quadraticCurveTo(x + width, y, x + width - radius, y);
    ctx.lineTo(x + radius, y);
    ctx.quadraticCurveTo(x, y, x, y + radius);
    ctx.fill();

  },
  topRoundedRect2: function (ctx, x, y, width, height, radius, headerStartColor, headerStopColor) {
    // Chrome is having trouble rendering the LinearGradient in this particular case
    if (navigator.userAgent.toLowerCase().indexOf('chrome') > -1) {
      ctx.fillStyle = 'rgba(' + headerStopColor.join(',') + ', 1)';
    } else {
      var lingrad = ctx.createLinearGradient(0, this.options.shadowBlur - 1, 0, height + this.options.shadowBlur + 3);
      lingrad.addColorStop(0, 'rgb(' + headerStartColor.join(',') + ')');
      lingrad.addColorStop(1, 'rgb(' + headerStopColor.join(',') + ')');
      ctx.fillStyle = lingrad;
    }
    ctx.beginPath();
    ctx.moveTo(x, y + radius);
    ctx.lineTo(x, y + height - radius);
    ctx.quadraticCurveTo(x, y + height, x + radius, y + height);
    ctx.lineTo(x + width - radius, y + height);
    ctx.quadraticCurveTo(x + width, y + height, x + width, y + height - radius);
    ctx.lineTo(x + width, y + radius);
    ctx.quadraticCurveTo(x + width, y, x + width - radius, y);
    ctx.lineTo(x + radius, y);
    ctx.quadraticCurveTo(x, y, x, y + radius);
    ctx.fill();
  },
  maximizebutton: function (ctx, x, y, rgbBg, aBg, rgb, a) {
    // Circle
    ctx.beginPath();
    ctx.arc(x, y, 7, 0, Math.PI * 2, true);
    ctx.fillStyle = 'rgba(' + rgbBg.join(',') + ',' + aBg + ')';
    ctx.fill();
    // X sign
    ctx.strokeStyle = 'rgba(' + rgb.join(',') + ',' + a + ')';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(x, y - 3.5);
    ctx.lineTo(x, y + 3.5);
    ctx.moveTo(x - 3.5, y);
    ctx.lineTo(x + 3.5, y);
    ctx.stroke();
  },
  closebutton: function (ctx, x, y, rgbBg, aBg, rgb, a) {
    // Circle
    ctx.beginPath();
    ctx.arc(x, y, 7, 0, Math.PI * 2, true);
    ctx.fillStyle = 'rgba(' + rgbBg.join(',') + ',' + aBg + ')';
    ctx.fill();
    // Plus sign
    ctx.strokeStyle = 'rgba(' + rgb.join(',') + ',' + a + ')';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(x - 3, y - 3);
    ctx.lineTo(x + 3, y + 3);
    ctx.moveTo(x + 3, y - 3);
    ctx.lineTo(x - 3, y + 3);
    ctx.stroke();
  },
  minimizebutton: function (ctx, x, y, rgbBg, aBg, rgb, a) {
    // Circle
    ctx.beginPath();
    ctx.arc(x, y, 7, 0, Math.PI * 2, true);
    ctx.fillStyle = 'rgba(' + rgbBg.join(',') + ',' + aBg + ')';
    ctx.fill();
    // Minus sign
    ctx.strokeStyle = 'rgba(' + rgb.join(',') + ',' + a + ')';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(x - 3.5, y);
    ctx.lineTo(x + 3.5, y);
    ctx.stroke();
  },
  setInssideControlsWidth: function () {
    this.inssideControlsWidth = 0;
    var options = this.options;
    if (options.minimizable) {
      this.inssideControlsWidth += (this.minimizeButtonEl.getStyle('margin-left').toInt() + this.minimizeButtonEl.getStyle('width').toInt());
    }
    if (options.maximizable) {
      this.inssideControlsWidth += (this.maximizeButtonEl.getStyle('margin-left').toInt() + this.maximizeButtonEl.getStyle('width').toInt());
    }
    if (options.closable) {
      this.inssideControlsWidth += (this.closeButtonEl.getStyle('margin-left').toInt() + this.closeButtonEl.getStyle('width').toInt());
    }
    this.controlsEl.setStyle('width', this.inssideControlsWidth);
    if (options.useCanvasControls == true) {
      this.canvasControlsEl.setProperty('width', this.inssideControlsWidth);
    }
  },
  /*
   
   Function: hideSpinner
   Hides the spinner.
   
   Example:
   (start code)
   $('myWindow').retrieve('instance').hideSpinner();
   (end)
   
   */
  hideSpinner: function () {
    if (this.spinnerEl)
      this.spinnerEl.hide();
    return this;
  },
  /*
   
   Function: showSpinner
   Shows the spinner.
   
   Example:
   (start code)
   $('myWindow').retrieve('instance').showSpinner();
   (end)
   
   */
  showSpinner: function () {
    if (this.spinnerEl)
      this.spinnerEl.show();
    return this;
  },
  /*
   
   Function: close
   Closes the window. This is an alternative to using MUI.Core.closeWindow().
   
   Example:
   (start code)
   $('myWindow').retrieve('instance').close();
   (end)
   
   */
  close: function () {
    if (!this.isClosing)
      MUI.closeWindow(this.windowEl);
    return this;
  },
  /*
   
   Function: minimize
   Minimizes the window.
   
   Example:
   (start code)
   $('myWindow').retrieve('instance').minimize();
   (end)
   
   */
  minimize: function () {
    MUI.Dock.minimizeWindow(this.windowEl);
    return this;
  },
  /*
   
   Function: maximize
   Maximizes the window.
   
   Example:
   (start code)
   $('myWindow').retrieve('instance').maximize();
   (end)
   
   */
  maximize: function () {
    if (this.isMinimized) {
      MUI.Dock.restoreMinimized(this.windowEl);
    }
    MUI.Desktop.maximizeWindow(this.windowEl);
    return this;
  },
  /*
   
   Function: restore
   Restores a minimized/maximized window to its original size.
   
   Example:
   (start code)
   $('myWindow').retrieve('instance').restore();
   (end)
   
   */
  restore: function () {
    if (this.isMinimized)
      MUI.Dock.restoreMinimized(this.windowEl);
    else if (this.isMaximized)
      MUI.Desktop.restoreWindow(this.windowEl);
    return this;
  },
  /*
   
   Function: resize
   Resize a window.
   
   Notes:
   If Advanced Effects are on the resize is animated. If centered is set to true the window remains centered as it resizes.
   
   Example:
   (start code)
   $('myWindow').retrieve('instance').resize({width:500,height:300,centered:true});
   (end)
   
   */
  resize: function (options) {
    MUI.resizeWindow(this.windowEl, options);
    return this;
  },
  /*
   
   Function: center
   Center a window.
   
   Example:
   (start code)
   $('myWindow').retrieve('instance').center();
   (end)
   
   */
  center: function () {
    MUI.centerWindow(this.windowEl);
    return this;
  },
  hide: function () {
    this.windowEl.setStyle('display', 'none');
    return this;
  },
  show: function () {
    this.windowEl.setStyle('display', 'block');
    return this;
  }
});
/** 1.2 */

/** Extendiendo Interface **/
Object.append(MUI, {
  /*
   
   Function: closeWindow
   Closes a window.
   
   Syntax:
   (start code)
   MUI.closeWindow();
   (end)
   
   Arguments:
   windowEl - the ID of the window to be closed
   
   Returns:
   true - the window was closed
   false - the window was not closed
   
   */
  titleWindow: function (windowEl, titulo) {
    var instance = windowEl.retrieve('instance');
    instance.titleEl.set('html', titulo);
  },
  closeWindow: function (windowEl) {

    var instance = windowEl.retrieve('instance');

    // Does window exist and is not already in process of closing ?
    if (windowEl != $(windowEl) || instance.isClosing)
      return;

    instance.isClosing = true;
    instance.fireEvent('onClose', windowEl);

    if (instance.options.storeOnClose) {
      this.storeOnClose(instance, windowEl);
      return;
    }
    if (instance.check)
      instance.check.destroy();

    if ((instance.options.type == 'modal' || instance.options.type == 'modal2') && Browser.ie4) {
      $('modalFix').hide();
    }

    if (MUI.options.advancedEffects == false) {
      if (instance.options.type == 'modal' || instance.options.type == 'modal2') {
        //$('modalOverlay').setStyle('opacity', 0);
        /** FIX **/
        $('modalOverlay').setStyles({
          'opacity': 0,
          'display': 'none'
        });


      }
      MUI.closingJobs(windowEl);
      return true;
    } else {
      // Redraws IE windows without shadows since IE messes up canvas alpha when you change element opacity
      if (Browser.ie)
        instance.drawWindow(false);
      if (instance.options.type == 'modal' || instance.options.type == 'modal2') {
        MUI.Modal.modalOverlayCloseMorph.start({
          'opacity': 0
        });
      }
      var closeMorph = new Fx.Morph(windowEl, {
        duration: 120,
        onComplete: function () {
          MUI.closingJobs(windowEl);
          return true;
        }.bind(this)
      });
      closeMorph.start({
        'opacity': .4
      });
    }

  },
  closingJobs: function (windowEl) {

    var instances = MUI.Windows.instances;

    /** 1.2 @todo */
    var instance = instances.get(windowEl.id);

    windowEl.setStyle('visibility', 'hidden');
    // Destroy throws an error in IE8
    if (Browser.ie) {
      windowEl.dispose();
    } else {
      windowEl.destroy();
    }
    instance.fireEvent('onCloseComplete');

    if (instance.options.type != 'notification') {
      var newFocus = this.getWindowWithHighestZindex();
      this.focusWindow(newFocus);
    }
    /** 1.2 @todo */
    instances.erase(instance.options.id);
    //delete instances.instance.options.id;

    if (this.loadingWorkspace == true) {
      this.windowUnload();
    }

    if (MUI.Dock && $(MUI.options.dock) && instance.options.type == 'window') {
      var currentButton = $(instance.options.id + '_dockTab');
      if (currentButton != null) {
        MUI.Dock.dockSortables.removeItems(currentButton).destroy();
      }
      // Need to resize everything in case the dock becomes smaller when a tab is removed
      MUI.Desktop.setDesktopSize();
    }
  },
  storeOnClose: function (instance, windowEl) {

    if (instance.check)
      instance.check.hide();

    windowEl.setStyles({
      zIndex: -1
    });
    windowEl.addClass('windowClosed');
    windowEl.removeClass('insside');

    if (MUI.Dock && $(MUI.options.dock) && instance.options.type == 'window') {
      var currentButton = $(instance.options.id + '_dockTab');
      if (currentButton != null) {
        currentButton.hide();
      }
      MUI.Desktop.setDesktopSize();
    }

    instance.fireEvent('onCloseComplete');

    if (instance.options.type != 'notification') {
      var newFocus = this.getWindowWithHighestZindex();
      this.focusWindow(newFocus);
    }

    instance.isClosing = false;

  },
  /*
   
   Function: closeAll
   Close all open windows.
   
   */
  closeAll: function () {
    $$('.insside').each(function (windowEl) {
      this.closeWindow(windowEl);
    }.bind(this));
  },
  /*
   
   Function: collapseToggle
   Collapses an expanded window. Expands a collapsed window.
   
   */
  collapseToggle: function (windowEl) {
    var instance = windowEl.retrieve('instance');
    var handles = windowEl.getElements('.handle');
    if (instance.isMaximized == true)
      return;
    if (instance.isCollapsed == false) {
      instance.isCollapsed = true;
      handles.hide();
      if (instance.iframeEl) {
        instance.iframeEl.setStyle('visibility', 'hidden');
      }
      instance.contentBorderEl.setStyles({
        visibility: 'hidden',
        position: 'absolute',
        top: -10000,
        left: -10000
      });
      if (instance.toolbarWrapperEl) {
        instance.toolbarWrapperEl.setStyles({
          visibility: 'hidden',
          position: 'absolute',
          top: -10000,
          left: -10000
        });
      }
      instance.drawWindowCollapsed();
    } else {
      instance.isCollapsed = false;
      instance.drawWindow();
      instance.contentBorderEl.setStyles({
        visibility: 'visible',
        position: null,
        top: null,
        left: null
      });
      if (instance.toolbarWrapperEl) {
        instance.toolbarWrapperEl.setStyles({
          visibility: 'visible',
          position: null,
          top: null,
          left: null
        });
      }
      if (instance.iframeEl) {
        instance.iframeEl.setStyle('visibility', 'visible');
      }
      handles.show();
    }
  },
  /*
   
   Function: toggleWindowVisibility
   Toggle window visibility with Ctrl-Alt-Q.
   
   */
  toggleWindowVisibility: function () {
    /** 1.2 MUI.Windows.instances.each(function(instance){ */
    Object.each(MUI.Windows.instances, function (instance) {
      if (instance.options.type == 'modal' || instance.options.type == 'modal2' || instance.isMinimized == true)
        return;
      var id = $(instance.options.id);
      if (id.getStyle('visibility') == 'visible') {
        if (instance.iframe) {
          instance.iframeEl.setStyle('visibility', 'hidden');
        }
        if (instance.toolbarEl) {
          instance.toolbarWrapperEl.setStyle('visibility', 'hidden');
        }
        instance.contentBorderEl.setStyle('visibility', 'hidden');
        id.setStyle('visibility', 'hidden');
        MUI.Windows.windowsVisible = false;
      } else {
        id.setStyle('visibility', 'visible');
        instance.contentBorderEl.setStyle('visibility', 'visible');
        if (instance.iframe) {
          instance.iframeEl.setStyle('visibility', 'visible');
        }
        if (instance.toolbarEl) {
          instance.toolbarWrapperEl.setStyle('visibility', 'visible');
        }
        MUI.Windows.windowsVisible = true;
      }
    }.bind(this));

  },
  focusWindow: function (windowEl, fireEvent) {

    // This is used with blurAll
    MUI.Windows.focusingWindow = true;
    var windowClicked = function () {
      MUI.Windows.focusingWindow = false;
    };
    windowClicked.delay(170, this);

    // Only focus when needed
    if ($$('.insside').length == 0)
      return;
    if (windowEl != $(windowEl) || windowEl.hasClass('isFocused'))
      return;

    var instances = MUI.Windows.instances;
    /** 1.2 @todo Hash.get **/
    var instance = instances.get(windowEl.id);

    if (instance.options.type == 'notification') {
      windowEl.setStyle('zIndex', 11001);
      return;
    }

    MUI.Windows.indexLevel += 2;
    windowEl.setStyle('zIndex', MUI.Windows.indexLevel);

    // Used when dragging and resizing windows
    $('windowUnderlay').setStyle('zIndex', MUI.Windows.indexLevel - 1).inject($(windowEl), 'after');

    // Fire onBlur for the window that lost focus.
    /** 1.2 Hash **/
    //instances.each(function(instance){
    Object.each(instances, function (instance) {
      if (instance.windowEl.hasClass('isFocused')) {
        instance.fireEvent('onBlur', instance.windowEl);
      }
      instance.windowEl.removeClass('isFocused');
    });

    if (MUI.Dock && $(MUI.options.dock) && instance.options.type == 'window') {
      MUI.Dock.makeActiveTab();
    }
    windowEl.addClass('isFocused');

    if (fireEvent != false) {
      instance.fireEvent('onFocus', windowEl);
    }

  },
  getWindowWithHighestZindex: function () {
    this.highestZindex = 0;
    $$('.insside').each(function (element) {
      this.zIndex = element.getStyle('zIndex');
      if (this.zIndex >= this.highestZindex) {
        this.highestZindex = this.zIndex;
      }
    }.bind(this));
    $$('.insside').each(function (element) {
      if (element.getStyle('zIndex') == this.highestZindex) {
        this.windowWithHighestZindex = element;
      }
    }.bind(this));
    return this.windowWithHighestZindex;
  },
  blurAll: function () {
    if (MUI.Windows.focusingWindow == false) {
      $$('.insside').each(function (windowEl) {
        var instance = windowEl.retrieve('instance');
        if (instance.options.type != 'modal' && instance.options.type != 'modal2') {
          windowEl.removeClass('isFocused');
        }
      });
      $$('.dockTab').removeClass('activeDockTab');
    }
  },
  centerWindow: function (windowEl) {

    if (!windowEl) {
      /** 1.2 MUI.Windows.instances.each(function(instance){ */
      Object.each(MUI.Windows.instances, function (instance) {
        if (instance.windowEl.hasClass('isFocused')) {
          windowEl = instance.windowEl;
        }
      });
    }
    if (windowEl) {// Alexis
      var instance = windowEl.retrieve('instance');
      var options = instance.options;
      var dimensions = options.container.getCoordinates();

      var windowPosTop = window.getScroll().y + (window.getSize().y * .5) - (windowEl.offsetHeight * .5);
      if (windowPosTop < -instance.options.shadowBlur) {
        windowPosTop = -instance.options.shadowBlur;
      }
      var windowPosLeft = (dimensions.width * .5) - (windowEl.offsetWidth * .5);
      if (windowPosLeft < -instance.options.shadowBlur) {
        windowPosLeft = -instance.options.shadowBlur;
      }
      if (MUI.options.advancedEffects == true) {
        instance.morph.start({
          'top': windowPosTop,
          'left': windowPosLeft
        });
      } else {
        windowEl.setStyles({
          'top': windowPosTop,
          'left': windowPosLeft
        });
      }
    }
  },
  resizeWindow: function (windowEl, options) {
    var instance = windowEl.retrieve('instance');

    //$extend({
    Object.append(this, {
      width: null,
      height: null,
      top: null,
      left: null,
      centered: true
    }, options);

    var oldWidth = windowEl.getStyle('width').toInt();
    var oldHeight = windowEl.getStyle('height').toInt();
    var oldTop = windowEl.getStyle('top').toInt();
    var oldLeft = windowEl.getStyle('left').toInt();

    if (options.centered) {
      var top = options.top || oldTop - ((options.height - oldHeight) * .5);
      var left = options.left || oldLeft - ((options.width - oldWidth) * .5);
    } else {
      var top = options.top || oldTop;
      var left = options.left || oldLeft;
    }

    if (MUI.options.advancedEffects == false) {
      windowEl.setStyles({
        'top': top,
        'left': left
      });
      instance.contentWrapperEl.setStyles({
        'height': options.height,
        'width': options.width
      });
      instance.drawWindow();
      // Show iframe
      if (instance.iframeEl) {
        if (!Browser.ie) {
          instance.iframeEl.setStyle('visibility', 'visible');
        } else {
          instance.iframeEl.show();
        }
      }
    } else {
      windowEl.retrieve('resizeMorph').start({
        '0': {
          'height': options.height,
          'width': options.width
        },
        '1': {
          'top': top,
          'left': left
        }
      });
    }
    return instance;
  },
  /*
   
   Internal Function: dynamicResize
   Use with a timer to resize a window as the window's content size changes, such as with an accordian.
   
   */
  dynamicResize: function (windowEl) {
    var instance = windowEl.retrieve('instance');
    var contentWrapperEl = instance.contentWrapperEl;
    var contentEl = instance.contentEl;

    contentWrapperEl.setStyles({
      'height': contentEl.offsetHeight,
      'width': contentEl.offsetWidth
    });
    instance.drawWindow();
  }
});
document.addEvent('keydown', function (event) {
  if (event.key == 'q' && event.control && event.alt) {
    MUI.toggleWindowVisibility();
  }
});



/*
 Script: Modal.js
 Create modal dialog windows.
 Copyright:
 Copyright (c) 2013 Jose Alexis Correa Valencia, <jalexiscv@gmail.com>.
 License:
 Privada
 Requires:
 Core.js, Window.js
 */
MUI.files[MUI.path.source + 'Window/Modal.js'] = 'loaded';
MUI.Modal =new Class({
  Extends: MUI.Window,
  options: {
    type: 'modal'
  },
  initialize: function(options) {
    if (!$('modalOverlay')) {
      this.modalInitialize();
      window.addEvent('resize', function() {
        this.setModalSize();
      }.bind(this));
    }
    this.parent(options);
  },
  modalInitialize: function() {
    var modalOverlay =new Element('div', {
      'id': 'modalOverlay',
      'styles': {
        'height': document.getCoordinates().height,
        'opacity': .6
      }
    }).inject(document.body);

    modalOverlay.setStyles({
      'position': Browser.ie4 ? 'absolute' : 'fixed'
    });
    modalOverlay.addEvent('click', function(e) {
      /** 1.2 @todo */
      e.stop();
      var instance = MUI.Windows.instances.get(MUI.currentModal.id);
      if (instance.options.modalOverlayClose == true) {
        MUI.closeWindow(MUI.currentModal);
      }
    });

    if (Browser.ie4) {
      var modalFix =new Element('iframe', {
        'id': 'modalFix',
        'scrolling': 'no',
        'marginWidth': 0,
        'marginHeight': 0,
        'src': '',
        'styles': {
          'height': document.getCoordinates().height
        }
      }).inject(document.body);
    }

    MUI.Modal.modalOverlayOpenMorph =new Fx.Morph($('modalOverlay'), {
      'duration': 150
    });
    MUI.Modal.modalOverlayCloseMorph =new Fx.Morph($('modalOverlay'), {
      'duration': 150,
      onComplete: function() {
        $('modalOverlay').hide();
        if (Browser.ie4) {
          $('modalFix').hide();
        }
      }.bind(this)
    });
  },
  setModalSize: function() {
    $('modalOverlay').setStyle('height', document.getCoordinates().height);
    if (Browser.ie4) {
      $('modalFix').setStyle('height', document.getCoordinates().height);
    }
  }
});


/**
 * Este componente permite  en un solo elemento generalmente conformado por un panel, cargar multiples
 * datos html mediante la invocacion de un actualizador de contenidos (updateContent) cada carga de datos
 * esta asociada a un vinculo activo en el encabezado. Como componente grafico esta previsto
 * para visualizarse en la barra de herramientas de un componente tipo ventana o en la parte superior de 
 * un panel. La creacion grafica del objeto corresponde a un elemento tipo UL cuya apariencia se controla 
 * mediante CSS con las clases "toolbarTabs" y "tab-menu" , las urls cargadas al accionar los vinculos son 
 * tomadas textualmente de los vinculos contenidos en los LI de la lista, la instruccion de inicializacion 
 * InssideUI.initializeTabs('tabs', 'content'); hace referencia a la identidad del objeto que se controlara "tabs" 
 * y la identidad del objeto que recibira las actualizaciones "content".
 * @param {type} param1
 * @param {type} param2
 */
Object.append(InssideUI, {
  initializeTabs: function(el, target) {
    $(el).getElements('li').each(function(listitem) {
      var link = listitem.getFirst('a').addEvent('click', function(e) {
        e.preventDefault();
      });
      listitem.addEvent('click', function(e) {
        var wcw = $(target).id + "_contentWrapper";
        var wc = $(target).id + "_content";
        var cargador = new Spinner($(wcw), {message: '...Procesando...'});
        if ($(wc) && MUI.options.standardEffects == true) {
          $(wc).setStyle('opacity', 1).get('morph').start({'opacity': 0});
        }
        cargador.show();
        InssideUI.updateContent({
          'element': $(target),
          'loadMethod': 'xhr',
          'url': link.get('href'),
          'require': {
            onload: function() {
            }
          }, onContentLoaded: function() {
            cargador.hide();
            if ($(wc) && MUI.options.standardEffects == true) {
              $(wc).setStyle('opacity', 0).get('morph').start({'opacity': 1});
            }
          }
        });
        InssideUI.selected(this, el);
      });
    });
  },
  selected: function(el, parent) {
    $(parent).getChildren().each(function(listitem) {
      listitem.removeClass('selected');
    });
    el.addClass('selected');
  }
});

