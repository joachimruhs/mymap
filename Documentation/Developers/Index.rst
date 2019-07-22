.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _developers-manual:

Developers manual
=================


Target group: **Developers**


Signal and Slots
^^^^^^^^^^^^^^^^
The extension provides some signals to extend the functionality of the extension with the 
signal/slot pattern and your own code.
See Classes/Controller/LocationController.php for details.

Following signals are implemented:
::

 $ret =$signalSlotDispatcher->dispatch(__CLASS__, 'beforeSearchRenderView', array(&$locations, &$this));
 $ret =$signalSlotDispatcher->dispatch(__CLASS__, 'beforeSingleRenderView', array(&$location, &$this));
 $ret =$signalSlotDispatcher->dispatch(__CLASS__, 'beforeRouteRenderView', array(&$this->_GP, &$this));




    



