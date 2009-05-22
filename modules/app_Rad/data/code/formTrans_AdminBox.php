                    case module[ModuleName]::[RAD_PAGE_SOURCE_CONSTNAME]:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->[RAD_TRANSITION_MANAGERINIT_NAME] = '';
                        $this->load[RAD_PAGEINIT_NAME]( true );                     
                        break;