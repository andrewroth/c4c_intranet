DELIMITER $$

DROP TRIGGER /*!50114 IF EXISTS */ `ciministry`.`cctrans_ins`$$

create trigger `ciministry`.`cctrans_ins` BEFORE INSERT on `ciministry`.`cim_reg_cctransaction` 
for each row BEGIN
    IF NEW.cctransaction_processed = 1 THEN UPDATE cim_reg_registration SET registration_balance = registration_balance - NEW.cctransaction_amount WHERE registration_id = NEW.reg_id;
    END IF;
  END;
$$

DELIMITER ;

DELIMITER $$

DROP TRIGGER /*!50114 IF EXISTS */ `ciministry`.`cctrans_upd`$$

create trigger `ciministry`.`cctrans_upd` BEFORE UPDATE on `ciministry`.`cim_reg_cctransaction` 
for each row BEGIN
    IF NEW.cctransaction_processed = 1 THEN 
	UPDATE cim_reg_registration SET registration_balance = registration_balance - NEW.cctransaction_amount WHERE registration_id = NEW.reg_id;		
    END IF;
  END;
$$

DELIMITER ;


DELIMITER $$

DROP TRIGGER /*!50114 IF EXISTS */ `ciministry`.`cashtrans_ins`$$

create trigger `ciministry`.`cashtrans_ins` BEFORE INSERT on `ciministry`.`cim_reg_cashtransaction` 
for each row BEGIN
    IF NEW.cashtransaction_recd = 1 THEN UPDATE cim_reg_registration SET registration_balance = registration_balance - NEW.cashtransaction_amtPaid WHERE registration_id = NEW.reg_id;
    END IF;
  END;
$$

DELIMITER ;

DELIMITER $$

DROP TRIGGER /*!50114 IF EXISTS */ `ciministry`.`cashtrans_upd`$$

create trigger `ciministry`.`cashtrans_upd` BEFORE UPDATE on `ciministry`.`cim_reg_cashtransaction` 
for each row BEGIN
    IF (OLD.cashtransaction_recd = 0 && NEW.cashtransaction_recd = 1) THEN 
	UPDATE cim_reg_registration SET registration_balance = registration_balance - NEW.cashtransaction_amtPaid WHERE registration_id = NEW.reg_id;		
    END IF;
    IF (OLD.cashtransaction_recd = 1 && NEW.cashtransaction_recd = 0) THEN 
	UPDATE cim_reg_registration SET registration_balance = registration_balance + OLD.cashtransaction_amtPaid WHERE registration_id = NEW.reg_id;		
    END IF;
    IF (OLD.cashtransaction_recd = 1 && NEW.cashtransaction_recd = 1) THEN 
	UPDATE cim_reg_registration SET registration_balance = registration_balance + (OLD.cashtransaction_amtPaid - NEW.cashtransaction_amtPaid) WHERE registration_id = NEW.reg_id;		
    END IF;	
  END;
$$

DELIMITER ;


DELIMITER $$

DROP TRIGGER /*!50114 IF EXISTS */ `ciministry`.`scholarship_ins`$$

create trigger `ciministry`.`scholarship_ins` BEFORE INSERT on `ciministry`.`cim_reg_scholarship` 
for each row BEGIN
    UPDATE cim_reg_registration SET registration_balance = registration_balance - NEW.scholarship_amount WHERE registration_id = NEW.registration_id;
  END;
$$

DELIMITER ;

DELIMITER $$

DROP TRIGGER /*!50114 IF EXISTS */ `ciministry`.`scholarship_upd`$$

create trigger `ciministry`.`scholarship_upd` BEFORE UPDATE on `ciministry`.`cim_reg_scholarship` 
for each row BEGIN
    UPDATE cim_reg_registration SET registration_balance = registration_balance + (OLD.scholarship_amount - NEW.scholarship_amount) WHERE registration_id = NEW.registration_id;		
  END;
$$

DELIMITER ;cim_reg_cashtransaction