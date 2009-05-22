                    case module[ModuleName]::[RAD_PAGE_SOURCE_CONSTNAME]:
                        [RAD_SOURCE_FORMINIT]
                        $this->page = module[ModuleName]::[RAD_PAGE_DEST_CONSTNAME];
                        $this->load[RAD_PAGE_DEST_NAME]();                       
                        break;