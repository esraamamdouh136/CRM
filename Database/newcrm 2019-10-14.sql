-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2019 at 07:24 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newcrm`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AgeReport` (IN `date1` DATE, IN `date2` DATE)  NO SQL
SELECT * from (
select '1' ,count(*) as count1 from customercrm
WHERE `customerCrmAge` < 20
AND customercrm.customerCrmId IN (SELECT Client_ID from client_orders WHERE client_orders.Date <= date2 AND  client_orders.Date >= date1)) as a1,(
select '2',count(*) as count2 from customercrm
WHERE `customerCrmAge` < 25 and `customerCrmAge` >= 20
AND customercrm.customerCrmId IN (SELECT Client_ID from client_orders WHERE client_orders.Date <= date2 AND  client_orders.Date >= date1))as a2,(
select '3',count(*) as count3 from customercrm
WHERE `customerCrmAge` < 30 and `customerCrmAge` >= 25
AND customercrm.customerCrmId IN (SELECT Client_ID from client_orders WHERE client_orders.Date <= date2 AND  client_orders.Date >= date1)) as a3,(
select '4',count(*) as count4 from customercrm
WHERE `customerCrmAge` < 35 and `customerCrmAge` >= 30
AND customercrm.customerCrmId IN (SELECT Client_ID from client_orders WHERE client_orders.Date <= date2 AND  client_orders.Date >= date1))as a4,(
select '5',count(*) as count5 from customercrm
WHERE `customerCrmAge` < 40 and `customerCrmAge` >= 35
AND customercrm.customerCrmId IN (SELECT Client_ID from client_orders WHERE client_orders.Date <= date2 AND  client_orders.Date >= date1))as a5,(
select '6',count(*) as count6 from customercrm
WHERE `customerCrmAge` < 45 and `customerCrmAge` >= 40
AND customercrm.customerCrmId IN (SELECT Client_ID from client_orders WHERE client_orders.Date <= date2 AND  client_orders.Date >= date1))as a6,(
select '7',count(*) as count7 from customercrm
WHERE `customerCrmAge` < 50 and `customerCrmAge` >= 45
AND customercrm.customerCrmId IN (SELECT Client_ID from client_orders WHERE client_orders.Date <= date2 AND  client_orders.Date >= date1))as a7,(
select '8',count(*) as count8 from customercrm
WHERE `customerCrmAge` < 55 and `customerCrmAge` >= 50
AND customercrm.customerCrmId IN (SELECT Client_ID from client_orders WHERE client_orders.Date <= date2 AND  client_orders.Date >= date1))as a8,(
select '9',count(*) as count9 from customercrm
WHERE `customerCrmAge` < 60 and `customerCrmAge` >= 55
AND customercrm.customerCrmId IN (SELECT Client_ID from client_orders WHERE client_orders.Date <= date2 AND  client_orders.Date >= date1)) as a9$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CallsReport` (IN `date1` DATE, IN `date2` DATE)  NO SQL
select Users.UID as userID,Users.Name,
sum(CASE WHEN SMS.SMSCount IS NULL THEN 0 ELSE SMS.SMSCount END) as SMSCount,
sum(CASE WHEN EMail.EmalsCount IS NULL THEN 0 ELSE EMail.EmalsCount END) as EMailCount,
sum(CASE WHEN notifications.notificationsCount IS NULL THEN 0 ELSE notifications.notificationsCount END) as notificationsCount,
sum(CASE WHEN CallsAVG.CallAVG IS NULL THEN 0 ELSE CallsAVG.CallAVG END) as CallAVG
 from (select DISTINCT(ID) AS UID,Name FROM crm_Users WHERE crm_Users.Type 	!= 1) as Users 
LEFT JOIN (SELECT COUNT(*) as SMSCount,UserID FROM crm_sms where crm_sms.Date <= date2 and	crm_sms.Date >= date1 GROUP BY UserID) as SMS
 on Users.UID = SMS.UserID
LEFT JOIN (SELECT COUNT(*) as EmalsCount,CrmMessagesFrom as UserID FROM messagecrm WHERE date(messagecrm.CrmMessagesCreateDate) <= date2 and	date(messagecrm.CrmMessagesCreateDate) >= date1 and CrmMessagesType = 2  GROUP BY UserID) as EMail
 on Users.UID = EMail.UserID
LEFT JOIN (SELECT COUNT(*) as notificationsCount,UserID FROM crm_notifications WHERE crm_notifications.Date <= date2 and	crm_notifications.Date >= date1 GROUP BY UserID) as notifications
 on Users.UID = notifications.UserID
LEFT JOIN (SELECT (AVG(TIME_TO_SEC(endcall - startcall))) as CallAVG,UserID FROM crm_calls WHERE crm_calls.date <= date2 and	crm_calls.date >= date1 and call_Result is NOT null GROUP BY UserID) as CallsAVG
 on Users.UID = CallsAVG.UserID
GROUP BY Users.UID ORDER BY Users.UID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EmpReport` (IN `date1` DATE, IN `date2` DATE)  NO SQL
select Users.UID as userID,Users.Name,(CASE WHEN tasks.cCount IS NULL THEN 0 ELSE tasks.cCount END) as TotalCalls
,(CASE WHEN NoAnswer.cCount IS NULL THEN 0 ELSE NoAnswer.cCount END) as NoAnswerCalls
,(CASE WHEN Follow.cCount IS NULL THEN 0 ELSE Follow.cCount END) as FollowCalls
,(CASE WHEN Reservation.cCount IS NULL THEN 0 ELSE Reservation.cCount END) as ReservationCalls
,(CASE WHEN contract.cCount IS NULL THEN 0 ELSE contract.cCount END) as contractCalls
,(CASE WHEN Decontract.cCount IS NULL THEN 0 ELSE Decontract.cCount END) as DecontractCalls
 from (select DISTINCT(ID) AS UID,Name FROM crm_Users WHERE crm_Users.Type 	= 3) as Users 
LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 employees_tasks where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1  GROUP By userID) as tasks 
 on Users.UID = tasks.userID 
LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 employees_tasks 
 where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1 and	employees_tasks.Status in (SELECT call_status.id FROM call_status WHERE call_status.status = 2)
 GROUP By userID) as NoAnswer
 on Users.UID = NoAnswer.userID  
LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 employees_tasks 
 where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1 and	employees_tasks.Status in (SELECT call_status.id FROM call_status WHERE call_status.follow = 1)
 GROUP By userID) as Follow
 on Users.UID = Follow.userID  
LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 employees_tasks 
 where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1 and	employees_tasks.Status in (SELECT call_status.id FROM call_status WHERE call_status.status = 3)
 GROUP By userID) as Reservation
 on Users.UID = Reservation.userID  
LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 employees_tasks 
 where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1 and	employees_tasks.Status in (SELECT call_status.id FROM call_status WHERE call_status.status = 5)
 GROUP By userID) as contract
 on Users.UID = contract.userID  
LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 employees_tasks 
 where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1 and	employees_tasks.Status in (SELECT call_status.id FROM call_status WHERE call_status.status = 6)
 GROUP By userID) as Decontract
 on Users.UID = Decontract.userID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EmpReportForSuperVisor` (IN `date1` DATE, IN `date2` DATE, IN `SuperID` INT)  NO SQL
select Users.UID as userID,Users.Name,(CASE WHEN tasks.cCount IS NULL THEN 0 ELSE tasks.cCount END) as TotalCalls
,(CASE WHEN NoAnswer.cCount IS NULL THEN 0 ELSE NoAnswer.cCount END) as NoAnswerCalls
,(CASE WHEN Follow.cCount IS NULL THEN 0 ELSE Follow.cCount END) as FollowCalls
,(CASE WHEN Reservation.cCount IS NULL THEN 0 ELSE Reservation.cCount END) as ReservationCalls
,(CASE WHEN contract.cCount IS NULL THEN 0 ELSE contract.cCount END) as contractCalls
,(CASE WHEN Decontract.cCount IS NULL THEN 0 ELSE Decontract.cCount END) as DecontractCalls
 from (select DISTINCT(ID) AS UID,Name,Super FROM crm_Users WHERE crm_Users.Type 	= 3) as Users 
LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 employees_tasks where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1  GROUP By userID) as tasks 
 on Users.UID = tasks.userID 
LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 employees_tasks 
 where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1 and	employees_tasks.Status in (SELECT call_status.id FROM call_status WHERE call_status.status = 2)
 GROUP By userID) as NoAnswer
 on Users.UID = NoAnswer.userID  
LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 employees_tasks 
 where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1 and	employees_tasks.Status in (SELECT call_status.id FROM call_status WHERE call_status.follow = 1)
 GROUP By userID) as Follow
 on Users.UID = Follow.userID  
LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 employees_tasks 
 where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1 and	employees_tasks.Status in (SELECT call_status.id FROM call_status WHERE call_status.status = 3)
 GROUP By userID) as Reservation
 on Users.UID = Reservation.userID  
LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 employees_tasks 
 where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1 and	employees_tasks.Status in (SELECT call_status.id FROM call_status WHERE call_status.status = 5)
 GROUP By userID) as contract
 on Users.UID = contract.userID  
LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 employees_tasks 
 where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1 and	employees_tasks.Status in (SELECT call_status.id FROM call_status WHERE call_status.status = 6)
 GROUP By userID) as Decontract
 on Users.UID = Decontract.userID
 where Users.Super = SuperID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetCallDuration` (IN `userID` INT, IN `clientID` INT)  NO SQL
SELECT (CASE WHEN SUBTIME(`endcall`,`startcall`) IS NULL THEN 0 ELSE SUBTIME(`endcall`,`startcall`) END) as Duration  FROM `crm_calls` WHERE call_Result is not null
and crm_calls.UserID = userID and crm_calls.ClientID = clientID
ORDER BY `date`,`startcall` DESC
LIMIT 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GovernmentReport` (IN `date1` DATE, IN `date2` DATE)  NO SQL
select `customerCrmGov`,count(*) as count from customercrm
WHERE customercrm.customerCrmId IN (SELECT Client_ID from client_orders WHERE client_orders.Date <= date2 AND client_orders.Date >= date1)
GROUP by customerCrmGov$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `HomeCallsReport` (IN `UserID` INT, IN `date1` DATE, IN `date2` DATE)  NO SQL
SELECT callStatus.title as CallStatus,SUM(CASE WHEN Taskes.Count IS NULL THEN 0 ELSE Taskes.Count END) as count
FROM
(select DISTINCT(call_status.id),call_status.title,call_status.status from call_status WHERE Status <> 0) as callStatus
LEFT JOIN
(SELECT COUNT(*) as Count,Status FROM employees_tasks 
 WHERE
 (employees_tasks.userID = UserID or employees_tasks.userID IN (SELECT ID FROM crm_users WHERE crm_users.Super = UserID))
and employees_tasks.Date <= date2 and	employees_tasks.Date >= date1
 
 GROUP BY employees_tasks.Status) AS Taskes
on callStatus.id = Taskes.Status
GROUP BY callStatus.id
ORDER BY callStatus.id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `HomeCallsReportForAdmin` (IN `date1` DATE, IN `date2` DATE)  NO SQL
SELECT callStatus.title as CallStatus,SUM(CASE WHEN Taskes.Count IS NULL THEN 0 ELSE Taskes.Count END) as count
FROM
(select DISTINCT(call_status.id),call_status.title,call_status.status from call_status WHERE Status <> 0) as callStatus
LEFT JOIN
(SELECT COUNT(*) as Count,Status FROM employees_tasks 
  WHERE
 employees_tasks.Date <= date2 and	employees_tasks.Date >= date1
 
 GROUP BY employees_tasks.Status) AS Taskes
on callStatus.id = Taskes.Status
GROUP BY callStatus.id
ORDER BY callStatus.id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `HomeDataReport` (IN `UserID` INT)  NO SQL
select * from (SELECT count(*) as newDataCount from customercrm WHERE DATE(customercrm.customerCrmCreateDate) =  DATE(now()) and customercrm.addedby = UserID) as newData,(SELECT count(*) as oldDataCount from customercrm WHERE DATE(customercrm.customerCrmCreateDate) < DATE(now())  and customercrm.addedby = UserID)as oldData$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `HomeDataReportForAdmin` ()  NO SQL
select * from (SELECT count(*) as newDataCount from customercrm WHERE date(customercrm.customerCrmCreateDate) = date(now())) as newData,(SELECT count(*) as oldDataCount from customercrm WHERE DATE(customercrm.customerCrmCreateDate) < DATE(now()))as oldData$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `JobReport` (IN `date1` DATE, IN `date2` DATE)  NO SQL
select `customerCrmJob`,count(*) as count from customercrm
WHERE customercrm.customerCrmId IN (SELECT Client_ID from client_orders WHERE client_orders.Date <= date2 AND  client_orders.Date >= date1)
GROUP by customerCrmJob$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ProductsReport` (IN `date1` DATE, IN `date2` DATE)  NO SQL
SELECT Product.PID,Product.PName,
(CASE WHEN sales.Pcount IS NULL THEN 0 ELSE sales.Pcount END) as PCount
 from (SELECT crm_products.Product_ID as PID,crm_products.Product_Name as PName from crm_products) as Product
LEFT JOIN (SELECT SUM(client_orders_details.Quantity) as Pcount ,client_orders_details.Unit_ID from client_orders_details 
          INNER JOIN client_orders on client_orders_details.Order_ID = client_orders.ID
           WHERE date(client_orders.Date) <= date2 AND date(client_orders.Date) >= date1
          GROUP by client_orders_details.Unit_ID) as sales
ON sales.Unit_ID = Product.PID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ReportCallStatus` (IN `CStatus` INT, IN `UserID` INT, IN `date1` DATE, IN `date2` DATE)  NO SQL
SELECT callStatus.title,(CASE WHEN Taskes.Count IS NULL THEN 0 ELSE Taskes.Count END) as count
FROM
(select * from call_status WHERE Status = CStatus) as callStatus
LEFT JOIN
(SELECT COUNT(*) as Count,Status FROM employees_tasks 
 WHERE
 (employees_tasks.userID = UserID or employees_tasks.userID IN (SELECT ID FROM crm_users WHERE crm_users.Super = UserID))
and	employees_tasks.Date <= date(date2) and	employees_tasks.Date >= date(date1)
 
 GROUP BY employees_tasks.Status) AS Taskes
on callStatus.id = Taskes.Status$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SuperReport` (IN `date1` DATE, IN `date2` DATE)  NO SQL
SELECT t1.*,t2.NoAnswerCalls,t3.FollowCalls,t4.ReservationCalls,t5.contractCalls,t6.DecontractCalls from (

select Users.UID as userID,Users.Name,sum(CASE WHEN tasks.cCount IS NULL THEN 0 ELSE tasks.cCount END) as TotalCalls
 from  (select DISTINCT(ID) AS UID,Name FROM crm_Users WHERE crm_Users.Type 	= 2) as Users 
  LEFT JOIN 
 (SELECT userID , COUNT(*) as cCount FROM  employees_tasks  where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1   GROUP By userID) as tasks 
  on (Users.UID = tasks.userID or (tasks.userID IN (SELECT ID from crm_Users WHERE crm_Users.Super =  Users.UID))) 
     GROUP BY Users.UID ORDER BY Users.UID) as t1
   
INNER JOIN

   (select Users.UID as userID,Users.Name,sum(CASE WHEN NoAnswer.cCount IS NULL THEN 0 ELSE NoAnswer.cCount END) as NoAnswerCalls
 from  (select DISTINCT(ID) AS UID,Name FROM crm_Users WHERE crm_Users.Type 	= 2) as Users 
 LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM  employees_tasks 
  where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1 and employees_tasks.Status in (SELECT call_status.id FROM call_status WHERE call_status.status = 2)
 GROUP By userID) as NoAnswer
 on (Users.UID = NoAnswer.userID or (NoAnswer.userID IN (SELECT ID from crm_Users WHERE crm_Users.Super =  Users.UID))) 
   GROUP BY Users.UID ORDER BY Users.UID) as t2
    on t1.userID = t2.userID
	
INNER JOIN
   (select Users.UID as userID,Users.Name,sum(CASE WHEN Follow.cCount IS NULL THEN 0 ELSE Follow.cCount END) as FollowCalls
 from  (select DISTINCT(ID) AS UID,Name FROM crm_Users WHERE crm_Users.Type 	= 2) as Users 
 LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM  employees_tasks 
  where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1 and  	employees_tasks.Status in (SELECT call_status.id FROM call_status WHERE call_status.follow = 1)
 GROUP By userID) as Follow
 on (Users.UID = Follow.userID or (Follow.userID IN (SELECT ID from crm_Users WHERE crm_Users.Super =  Users.UID))) 
   GROUP BY Users.UID ORDER BY Users.UID) as t3
   on t1.userID = t3.userID 
     INNER JOIN
   (select Users.UID as userID,Users.Name,sum(CASE WHEN Reservation.cCount IS NULL THEN 0 ELSE Reservation.cCount END) as ReservationCalls
 from  (select DISTINCT(ID) AS UID,Name FROM crm_Users WHERE crm_Users.Type 	= 2) as Users 
 LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM  employees_tasks 
  where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1 and  	employees_tasks.Status in (SELECT call_status.id FROM call_status WHERE call_status.status =3)
 GROUP By userID) as Reservation
 on (Users.UID = Reservation.userID or (Reservation.userID IN (SELECT ID from crm_Users WHERE crm_Users.Super =  Users.UID))) 
   GROUP BY Users.UID ORDER BY Users.UID) as t4
       on t1.userID = t4.userID
        INNER JOIN
   (select Users.UID as userID,Users.Name,sum(CASE WHEN contract.cCount IS NULL THEN 0 ELSE contract.cCount END) as contractCalls
 from  (select DISTINCT(ID) AS UID,Name FROM crm_Users WHERE crm_Users.Type 	= 2) as Users 
 LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM  employees_tasks 
  where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1 and  	employees_tasks.Status in (SELECT call_status.id FROM call_status WHERE call_status.status = 5)
 GROUP By userID) as contract
 on (Users.UID = contract.userID or (contract.userID IN (SELECT ID from crm_Users WHERE crm_Users.Super =  Users.UID))) 
   GROUP BY Users.UID ORDER BY Users.UID) as t5
       on t1.userID = t5.userID
    INNER JOIN
   (select Users.UID as userID,Users.Name,sum(CASE WHEN Decontract.cCount IS NULL THEN 0 ELSE Decontract.cCount END) as DecontractCalls
 from  (select DISTINCT(ID) AS UID,Name FROM crm_Users WHERE crm_Users.Type 	= 2) as Users 
 LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM  employees_tasks 
  where employees_tasks.Date <= date2 and	employees_tasks.Date >= date1 and  	employees_tasks.Status in (SELECT call_status.id FROM call_status WHERE call_status.status = 6)
 GROUP By userID) as Decontract
 on (Users.UID = Decontract.userID or (Decontract.userID IN (SELECT ID from crm_Users WHERE crm_Users.Super =  Users.UID))) 
   GROUP BY Users.UID ORDER BY Users.UID) as t6
    on t1.userID = t6.userID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UserCallsCount` (IN `UserID` INT, IN `date1` DATE, IN `date2` DATE)  NO SQL
select 
(CASE WHEN sum(UserCalls.count) IS NULL THEN 0 ELSE sum(UserCalls.count) END)
 as total FROM
(select COUNT(*) as count, employees_tasks.userID from employees_tasks 
WHERE (employees_tasks.userID = UserID or employees_tasks.userID IN (SELECT ID FROM crm_users WHERE crm_users.Super = UserID))
and	employees_tasks.Date <= date2 and	employees_tasks.Date >= date1
GROUP BY userID) as UserCalls$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UserCallsWithStatusType` (IN `UserID` INT, IN `statusType` INT, IN `date1` DATE, IN `date2` DATE)  NO SQL
select (CASE WHEN sum(UserCalls.count) IS NULL THEN 0 ELSE sum(UserCalls.count) END) as total FROM
(select COUNT(*) as count, employees_tasks.userID from employees_tasks 
WHERE (employees_tasks.userID = UserID or employees_tasks.userID IN (SELECT ID FROM crm_users WHERE crm_users.Super = UserID))
AND employees_tasks.Status in (SELECT id from call_status WHERE Status = statusType)
and	employees_tasks.Date <= date2 and	employees_tasks.Date >= date1
GROUP BY userID) as UserCalls$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `customercrm` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `calendercrm`
--

CREATE TABLE `calendercrm` (
  `CalenderCrmId` int(11) NOT NULL,
  `CalenderCrmDate` datetime NOT NULL,
  `CalenderCrmUser` int(11) NOT NULL,
  `CalenderCrmContent` varchar(255) NOT NULL,
  `CalenderCrmCreateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CalenderCrmUpdateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `call_status`
--

CREATE TABLE `call_status` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `at_home` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `follow` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `call_status`
--

INSERT INTO `call_status` (`id`, `status`, `title`, `at_home`, `type`, `follow`, `is_active`) VALUES
(1, 0, 'حالة جديدة', 0, 0, 0, 0),
(4, 3, 'موعد شحن أو تعاقد', 1, 1, 0, 1),
(7, 3, 'شحن مباشر', 1, 1, 0, 1),
(10, 0, 'تعاقد', 0, 0, 0, 0),
(15, 1, 'متابعه', 1, 1, 1, 1),
(20, 2, 'لم يتم الرد مرة واحدة', 1, 2, 1, 0),
(21, 1, 'سيتواصل', 1, 1, 1, 1),
(25, 2, 'لم يتم الرد مرتان', 1, 2, 1, 1),
(26, 2, 'لم يتم الرد ثلاث مرات', 1, 2, 0, 1),
(27, 2, 'لم يتم الرد مطلقا', 1, 2, 0, 1),
(29, 1, 'في إنتظار مراجعه الإدارة', 1, 1, 1, 1),
(30, 3, 'تم الشحن فى انتظار التسليم ', 1, 1, 0, 1),
(31, 2, 'مشكلة بالشبكة ', 1, 2, 0, 1),
(32, 4, 'غير موجود بالخدمة', 1, 3, 0, 1),
(33, 4, 'رقم غير صحيح', 1, 3, 0, 1),
(35, 4, 'بيانات غير صحيحه', 1, 3, 0, 1),
(36, 1, 'إلغاء متابعة', 1, 1, 0, 1),
(38, 1, 'غير جاد ', 1, 1, 0, 1),
(39, 1, '  في انتظار السداد / كاش / بنك ', 1, 1, 0, 1),
(40, 3, 'تم السداد بالمقر', 1, 1, 0, 1),
(41, 5, 'تم التعاقد بكامل المبلغ ', 1, 4, 0, 1),
(42, 6, 'مرتد', 0, 5, 0, 1),
(43, 5, 'تم التعاقد بجزء من المبلغ', 1, 4, 0, 0),
(45, 6, 'مرتجع', 0, 5, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `call_status2`
--

CREATE TABLE `call_status2` (
  `id` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `Status_Parent` int(11) DEFAULT NULL,
  `Status_Name` varchar(100) NOT NULL,
  `Answer_Status` int(1) NOT NULL DEFAULT '0',
  `Is_Confirm` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `call_status2`
--

INSERT INTO `call_status2` (`id`, `Status`, `Status_Parent`, `Status_Name`, `Answer_Status`, `Is_Confirm`) VALUES
(1, 1, NULL, 'حالة جديدة', 0, 0),
(2, 2, NULL, 'شراء', 1, 4),
(3, 3, NULL, 'قيد الحجز', 3, 0),
(4, 4, NULL, 'متابعه', 1, 1),
(5, 5, NULL, 'إلغاء متابعه', 2, 3),
(6, 1, 3, 'شحن', 1, 2),
(7, 2, 3, 'زيارة', 1, 2),
(8, 3, 3, 'حجز', 1, 2),
(9, 4, 3, 'موعد تحويل', 1, 2),
(10, 5, 3, 'حاله تبع قيد الحجز', 1, 2),
(11, 1, 4, 'سيتواصل', 1, 1),
(12, 2, 4, 'انقطاع الاتصال', 1, 1),
(13, 3, 4, 'مشغول', 2, 1),
(14, 4, 4, 'مغلق', 2, 1),
(15, 5, 4, 'غير متاح', 2, 1),
(16, 6, 4, 'حاله جديده في تم الرد', 1, 1),
(17, 1, 5, 'رقم خطأ', 2, 3),
(18, 2, 5, 'غير موجود بالخدمه', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `changecrm`
--

CREATE TABLE `changecrm` (
  `changecrmID` int(11) NOT NULL,
  `Content` varchar(500) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `changecrm`
--

INSERT INTO `changecrm` (`changecrmID`, `Content`, `type`) VALUES
(1, 'المكالمات', 1),
(2, 'تنبيهات بالمكالمات القادمة', 2),
(3, 'إستيراد / تعيين', 3),
(4, 'الموارد البشرية', 4),
(5, 'عملاء', 5),
(6, 'رسائل', 6),
(7, 'ايميل', 7),
(8, 'رسائل داخلية', 8),
(9, 'ملاحظات وشكاوى العملاء', 9),
(10, 'الاعدادات', 10),
(11, ' تقارير الشاملة', 11),
(12, 'حالات العملاء', 12),
(13, 'مكالمات فائته و محولة', 13);

-- --------------------------------------------------------

--
-- Table structure for table `client_notes`
--

CREATE TABLE `client_notes` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `NoteText` text NOT NULL,
  `Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `client_orders`
--

CREATE TABLE `client_orders` (
  `ID` int(11) NOT NULL,
  `Client_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Discount` int(11) NOT NULL DEFAULT '0',
  `Transfer_Cost` int(11) NOT NULL DEFAULT '0',
  `Order_Cost` int(11) NOT NULL DEFAULT '0',
  `Net_Cost` int(11) NOT NULL DEFAULT '0',
  `isDeleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client_orders`
--

INSERT INTO `client_orders` (`ID`, `Client_ID`, `User_ID`, `Date`, `Discount`, `Transfer_Cost`, `Order_Cost`, `Net_Cost`, `isDeleted`) VALUES
(31, 854, 45, '2019-10-07 13:46:38', 0, 50, 3500, 3550, b'0'),
(33, 754, 3, '2019-10-07 17:58:12', 0, 0, 100, 100, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `client_orders_details`
--

CREATE TABLE `client_orders_details` (
  `ID` int(11) NOT NULL,
  `Order_ID` int(11) NOT NULL,
  `Transfer_ID` int(11) NOT NULL,
  `Payment_ID` int(11) NOT NULL,
  `Unit_ID` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client_orders_details`
--

INSERT INTO `client_orders_details` (`ID`, `Order_ID`, `Transfer_ID`, `Payment_ID`, `Unit_ID`, `Price`, `Quantity`) VALUES
(46, 31, 8, 7, 9, 100, 20),
(47, 31, 7, 7, 10, 150, 10),
(49, 33, 7, 7, 9, 100, 1);

-- --------------------------------------------------------

--
-- Table structure for table `client_payments`
--

CREATE TABLE `client_payments` (
  `ID` int(11) NOT NULL,
  `Client_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Order_ID` int(11) NOT NULL,
  `Amount` int(11) NOT NULL,
  `paid` int(11) NOT NULL DEFAULT '0',
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client_payments`
--

INSERT INTO `client_payments` (`ID`, `Client_ID`, `User_ID`, `Order_ID`, `Amount`, `paid`, `Date`) VALUES
(31, 854, 45, 31, 3550, 3550, '2019-10-07 13:46:38'),
(33, 754, 3, 33, 100, 100, '2019-10-07 17:58:12');

-- --------------------------------------------------------

--
-- Table structure for table `communication_settings`
--

CREATE TABLE `communication_settings` (
  `id` int(11) NOT NULL,
  `Mail_Address` text NOT NULL,
  `Mail_Server` text NOT NULL,
  `Port` varchar(5) NOT NULL DEFAULT '587',
  `Mail_Password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `communication_settings`
--

INSERT INTO `communication_settings` (`id`, `Mail_Address`, `Mail_Server`, `Port`, `Mail_Password`) VALUES
(1, 'imct@imct.center', 'mail.imct.center', '587', 'Imct119955119955');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `To_User` int(11) DEFAULT NULL,
  `Client_ID` int(11) DEFAULT NULL,
  `Titel` varchar(30) NOT NULL,
  `To_Super` bit(1) NOT NULL DEFAULT b'0',
  `Super_Deleted` bit(1) NOT NULL DEFAULT b'0',
  `Sender_Deleted` bit(1) NOT NULL DEFAULT b'0',
  `Admin_Deleted` bit(1) NOT NULL DEFAULT b'0',
  `Is_Seen` bit(1) NOT NULL DEFAULT b'0',
  `Admin_Seen` bit(1) NOT NULL DEFAULT b'0',
  `Type` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`ID`, `UserID`, `To_User`, `Client_ID`, `Titel`, `To_Super`, `Super_Deleted`, `Sender_Deleted`, `Admin_Deleted`, `Is_Seen`, `Admin_Seen`, `Type`) VALUES
(8, 47, NULL, NULL, 'testss', b'0', b'0', b'1', b'1', b'0', b'1', b'0'),
(9, 45, NULL, 650, 'test', b'0', b'0', b'0', b'0', b'0', b'1', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `complaints_details`
--

CREATE TABLE `complaints_details` (
  `ID` int(11) NOT NULL,
  `complaints_ID` int(11) NOT NULL,
  `Owner_ID` int(11) NOT NULL,
  `complaints_details` text NOT NULL,
  `Send_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaints_details`
--

INSERT INTO `complaints_details` (`ID`, `complaints_ID`, `Owner_ID`, `complaints_details`, `Send_Date`) VALUES
(17, 8, 47, '&lt;p&gt;asd&lt;/p&gt;\r\n', '2019-10-07 15:00:28'),
(18, 8, 47, '&lt;p&gt;asdasdasdasasdas&lt;/p&gt;\r\n', '2019-10-07 15:05:42'),
(19, 8, 47, '&lt;p&gt;asdasdasdas&lt;/p&gt;\r\n', '2019-10-07 15:13:17'),
(20, 9, 45, '&lt;p&gt;1234421&lt;/p&gt;\n', '2019-10-07 15:32:26'),
(21, 9, 45, '&lt;p&gt;asd&lt;/p&gt;\r\n', '2019-10-07 15:37:44'),
(22, 9, 45, '&lt;p&gt;wytereterte&lt;/p&gt;\r\n', '2019-10-07 15:40:07'),
(23, 9, 3, '&lt;p&gt;???&lt;/p&gt;\r\n', '2019-10-07 15:53:48');

-- --------------------------------------------------------

--
-- Table structure for table `crm_calls`
--

CREATE TABLE `crm_calls` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `startcall` time NOT NULL,
  `endcall` time NOT NULL,
  `call_Result` int(11) DEFAULT NULL,
  `CommentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crm_calls`
--

INSERT INTO `crm_calls` (`ID`, `UserID`, `ClientID`, `date`, `startcall`, `endcall`, `call_Result`, `CommentID`) VALUES
(125, 45, 852, '2019-10-07', '12:42:46', '12:42:54', 32, NULL),
(127, 45, 942, '2019-10-07', '12:43:31', '12:45:14', 27, NULL),
(128, 45, 943, '2019-10-07', '12:45:36', '12:45:53', 29, NULL),
(129, 45, 930, '2019-10-07', '12:46:05', '12:46:37', 36, NULL),
(131, 45, 941, '2019-10-07', '12:47:54', '00:00:00', NULL, NULL),
(132, 45, 941, '2019-10-07', '12:49:14', '12:49:27', 15, NULL),
(135, 45, 940, '2019-10-07', '12:54:59', '12:57:05', 35, 20),
(136, 45, 944, '2019-10-07', '12:57:23', '12:58:11', 39, NULL),
(137, 45, 945, '2019-10-07', '12:58:26', '12:58:46', 31, NULL),
(138, 45, 948, '2019-10-07', '12:58:55', '12:59:08', 29, NULL),
(139, 45, 946, '2019-10-07', '12:59:18', '12:59:33', 38, NULL),
(140, 45, 947, '2019-10-07', '12:59:42', '12:59:56', 21, NULL),
(141, 45, 949, '2019-10-07', '13:00:08', '13:00:23', 39, NULL),
(142, 45, 950, '2019-10-07', '13:00:35', '13:00:48', 26, NULL),
(143, 45, 951, '2019-10-07', '13:00:58', '13:01:11', 29, NULL),
(144, 45, 853, '2019-10-07', '13:01:28', '13:01:40', 38, NULL),
(145, 45, 854, '2019-10-07', '13:46:08', '13:46:38', 4, NULL),
(146, 45, 854, '2019-10-07', '13:56:20', '00:00:00', NULL, NULL),
(147, 46, 854, '2019-10-07', '13:57:34', '00:00:00', NULL, NULL),
(148, 45, 854, '2019-10-07', '14:09:38', '00:00:00', NULL, NULL),
(149, 45, 854, '2019-10-07', '14:13:34', '14:13:41', NULL, NULL),
(150, 46, 854, '2019-10-07', '14:15:26', '14:15:50', 41, NULL),
(151, 46, 854, '2019-10-07', '14:21:20', '00:00:00', NULL, NULL),
(152, 45, 855, '2019-10-07', '14:21:49', '14:22:20', 7, NULL),
(153, 46, 855, '2019-10-07', '14:24:26', '14:24:36', 41, NULL),
(154, 46, 855, '2019-10-07', '14:32:11', '14:32:50', 45, 21),
(155, 45, 941, '2019-10-07', '17:06:06', '17:06:27', 31, NULL),
(157, 45, 947, '2019-10-07', '17:18:29', '17:19:30', 21, 22),
(158, 3, 754, '2019-10-07', '17:56:46', '17:58:12', 40, NULL),
(159, 3, 754, '2019-10-07', '17:58:29', '17:59:00', 41, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `crm_call_notifications`
--

CREATE TABLE `crm_call_notifications` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Befor15M` bit(1) NOT NULL DEFAULT b'0',
  `Befor10M` bit(1) NOT NULL DEFAULT b'0',
  `Befor5M` bit(1) NOT NULL DEFAULT b'0',
  `After5M` bit(1) NOT NULL DEFAULT b'0',
  `After10M` bit(1) NOT NULL DEFAULT b'0',
  `After15M` bit(1) NOT NULL DEFAULT b'0',
  `FollowID` int(11) NOT NULL,
  `ForSupervisor` bit(1) NOT NULL DEFAULT b'0',
  `ForAdmin` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `crm_call_notifications`
--

INSERT INTO `crm_call_notifications` (`ID`, `UserID`, `Befor15M`, `Befor10M`, `Befor5M`, `After5M`, `After10M`, `After15M`, `FollowID`, `ForSupervisor`, `ForAdmin`) VALUES
(30, 45, b'1', b'1', b'1', b'1', b'1', b'1', 32, b'0', b'1'),
(33, 45, b'1', b'1', b'1', b'1', b'1', b'1', 35, b'0', b'1'),
(34, 45, b'1', b'1', b'1', b'1', b'1', b'1', 36, b'0', b'1'),
(35, 45, b'1', b'1', b'1', b'1', b'1', b'1', 37, b'0', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `crm_comments`
--

CREATE TABLE `crm_comments` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `Comment_Text` text NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `IsFollowComment` bit(1) NOT NULL DEFAULT b'0',
  `FollowID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crm_comments`
--

INSERT INTO `crm_comments` (`ID`, `UserID`, `ClientID`, `Comment_Text`, `date`, `time`, `IsFollowComment`, `FollowID`) VALUES
(20, 45, 940, '&lt;p style=&quot;text-align:center&quot;&gt; &lt;/p&gt;\r\n\r\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;color:#16a085&quot;&gt;&lt;span style=&quot;font-size:24px&quot;&gt;&lt;span style=&quot;font-family:Times New Roman,Times,serif&quot;&gt;&lt;span style=&quot;background-color:#4e5f70&quot;&gt;البيانات كلها غلط&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n', '2019-10-07', '12:57:05', b'0', NULL),
(21, 46, 855, '&lt;p&gt;غير مطابق للمواصفات&lt;/p&gt;\r\n', '2019-10-07', '14:32:50', b'0', NULL),
(22, 45, 947, '&lt;p&gt;5555&lt;/p&gt;\r\n', '2019-10-07', '17:19:30', b'1', 36),
(23, 45, 947, '&lt;p&gt;egdfgfdgdfgdf&lt;/p&gt;\n', '2019-10-13', '19:00:28', b'0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `crm_empnotifications`
--

CREATE TABLE `crm_empnotifications` (
  `UserID` int(11) NOT NULL,
  `HaveNewCalls` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `crm_empnotifications`
--

INSERT INTO `crm_empnotifications` (`UserID`, `HaveNewCalls`) VALUES
(34, b'1'),
(38, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `crm_follows`
--

CREATE TABLE `crm_follows` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `Follow_Date` date NOT NULL,
  `Follow_Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crm_follows`
--

INSERT INTO `crm_follows` (`ID`, `UserID`, `ClientID`, `Follow_Date`, `Follow_Time`) VALUES
(32, 45, 943, '2019-10-08', '13:00:00'),
(35, 45, 948, '2019-10-09', '14:00:00'),
(36, 45, 947, '2019-10-07', '17:30:00'),
(37, 45, 951, '2019-10-07', '14:00:00');

--
-- Triggers `crm_follows`
--
DELIMITER $$
CREATE TRIGGER `DeleteFollowNotification` BEFORE DELETE ON `crm_follows` FOR EACH ROW DELETE FROM crm_call_notifications where crm_call_notifications.`FollowID` = OLD.ID
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `InserFollowNotification` AFTER INSERT ON `crm_follows` FOR EACH ROW INSERT INTO crm_call_notifications (`UserID`,`FollowID`) VALUES (NEW.UserID,NEW.ID)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateFollowNotification` AFTER UPDATE ON `crm_follows` FOR EACH ROW UPDATE crm_call_notifications 
SET `Befor15M`=0,`Befor10M`=0,`Befor5M`=0,
`After5M`=0,`After10M`=0,`After15M`=0,
`ForSupervisor`=0,`ForAdmin`=0
where crm_call_notifications.`FollowID` = OLD.ID
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `crm_internal_messages`
--

CREATE TABLE `crm_internal_messages` (
  `ID` int(11) NOT NULL,
  `From_User` int(11) NOT NULL,
  `To_User` int(11) NOT NULL,
  `Titel` varchar(30) NOT NULL,
  `Message` varchar(300) NOT NULL,
  `Send_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ISRead` int(11) NOT NULL,
  `Message_Type` int(11) NOT NULL,
  `Client_ID` int(11) DEFAULT NULL,
  `ownerUserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `crm_internal_messages_types`
--

CREATE TABLE `crm_internal_messages_types` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crm_internal_messages_types`
--

INSERT INTO `crm_internal_messages_types` (`ID`, `Name`) VALUES
(1, 'رسائل'),
(2, 'شكاوى'),
(3, 'تنبيات'),
(4, 'ملاحظات'),
(5, 'تعليمات');

-- --------------------------------------------------------

--
-- Table structure for table `crm_mails`
--

CREATE TABLE `crm_mails` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ClientID` int(11) DEFAULT NULL,
  `Mail` text NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Message` text NOT NULL,
  `Date` date NOT NULL,
  `DeleteForEmployee` bit(1) NOT NULL DEFAULT b'0',
  `DeleteForSupervisor` bit(1) NOT NULL DEFAULT b'0',
  `DeleteForAdmin` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `crm_mails`
--

INSERT INTO `crm_mails` (`ID`, `UserID`, `ClientID`, `Mail`, `Title`, `Message`, `Date`, `DeleteForEmployee`, `DeleteForSupervisor`, `DeleteForAdmin`) VALUES
(51, 45, NULL, 'abdob2623@gmail.com', 'test message', '<hr />\r\n<p style=\"text-align:center\"><span style=\"font-size:22px\"><span style=\"color:#1abc9c\">First line</span></span></p>\r\n\r\n<hr />\r\n<p style=\"text-align:center\"><span style=\"color:#d35400\"><span style=\"font-size:22px\">Second Line</span></span></p>\r\n', '2019-10-07', b'1', b'0', b'0'),
(52, 45, NULL, 'abdob2623@gmail.com;sherif.farouk@elfaroukegypt.com', 'test message22', '&lt;p&gt;asdasdadadasdasdas&lt;/p&gt;\r\n', '2019-10-07', b'1', b'0', b'0'),
(53, 45, NULL, 'abdob2623@gmail.com;', 'asdasdas', '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;color:#2980b9&quot;&gt;&lt;span style=&quot;font-size:48px&quot;&gt;asdasdasdasdasdas&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n', '2019-10-07', b'0', b'0', b'0'),
(54, 45, NULL, 'abdob2623@gmail.com;', 'new SMTP', '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;color:#3498db&quot;&gt;&lt;span style=&quot;font-family:Arial,Helvetica,sans-serif&quot;&gt;Test New SMTP&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n', '2019-10-07', b'1', b'0', b'0'),
(55, 45, NULL, 'abdob2623@gmail.com;', 'pdf', '&lt;p style=&quot;text-align:center&quot;&gt;asdasdqwdasdsadsa&lt;/p&gt;\r\n', '2019-10-07', b'0', b'0', b'0'),
(56, 45, NULL, 'abdob2623@gmail.com;', 'asdsadas', '&lt;p style=&quot;text-align:center&quot;&gt;asdsadsadas&lt;/p&gt;\r\n', '2019-10-07', b'0', b'0', b'0'),
(57, 45, NULL, 'abdob2623@gmail.com;', 'pdf252', '&lt;p&gt;asdasdasdas&lt;/p&gt;\r\n', '2019-10-07', b'0', b'0', b'0'),
(58, 45, NULL, 'abdob2623@gmail.com;', '12312', '&lt;p&gt;123213212z13&lt;/p&gt;\r\n', '2019-10-07', b'0', b'0', b'0'),
(59, 45, NULL, 'abdob2623@gmail.com;', '23456789uy', '&lt;p&gt;sadfghjkhgfd&lt;/p&gt;\r\n', '2019-10-07', b'0', b'0', b'0'),
(60, 3, NULL, 'abdob2623@gmail.com;', 'test message', '&lt;p&gt;asdasdas&lt;/p&gt;\r\n', '2019-10-07', b'0', b'0', b'0'),
(61, 3, NULL, 'abdob2623@gmail.com;', 'pdf and image', '&lt;p&gt;vdfgfhjngjhg&lt;/p&gt;\r\n', '2019-10-07', b'0', b'0', b'0'),
(62, 3, 650, 'abdob2623@gmail.com', 'ssss444', '<p>6666</p>\r\n', '2019-10-07', b'0', b'0', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `crm_messages`
--

CREATE TABLE `crm_messages` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Titel` varchar(100) NOT NULL,
  `Deleted` bit(1) NOT NULL DEFAULT b'0',
  `Admin_Delete` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crm_messages`
--

INSERT INTO `crm_messages` (`ID`, `UserID`, `Titel`, `Deleted`, `Admin_Delete`) VALUES
(14, 46, 'طلبيات اليوم', b'0', b'0'),
(15, 45, 'اى حاجة', b'1', b'0'),
(16, 45, '13456', b'1', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `crm_messages_details`
--

CREATE TABLE `crm_messages_details` (
  `ID` int(11) NOT NULL,
  `Message_ID` int(11) NOT NULL,
  `Owner_ID` int(11) NOT NULL,
  `Message_Details` text NOT NULL,
  `Send_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crm_messages_details`
--

INSERT INTO `crm_messages_details` (`ID`, `Message_ID`, `Owner_ID`, `Message_Details`, `Send_Date`) VALUES
(26, 14, 46, '&lt;p&gt;تم تسليم لعميل والعميل الاخر مرتجع&lt;/p&gt;\r\n', '2019-10-07 14:34:27'),
(27, 14, 45, '&lt;p&gt;&lt;br /&gt;\r\n&lt;img alt=&quot;smiley&quot; height=&quot;55&quot; src=&quot;http://localhost:8072/crmNewDesign/design/vendors/ckeditor4-major/plugins/smiley/images/regular_smile.png&quot; title=&quot;smiley&quot; width=&quot;55&quot; /&gt;&lt;/p&gt;\r\n', '2019-10-07 14:40:37'),
(28, 15, 45, '&lt;p&gt;1234&lt;/p&gt;\r\n', '2019-10-07 14:41:58'),
(29, 15, 46, '&lt;p&gt;12345678&lt;/p&gt;\r\n', '2019-10-07 14:42:34'),
(30, 16, 45, '&lt;p&gt;12456743214565&lt;/p&gt;\r\n', '2019-10-07 14:44:55'),
(31, 16, 44, '&lt;p&gt;asd&lt;/p&gt;\r\n', '2019-10-07 14:51:02'),
(32, 16, 47, '&lt;p&gt;asd&lt;/p&gt;\r\n', '2019-10-07 14:51:47'),
(33, 16, 46, '&lt;p&gt;369852147&lt;/p&gt;\r\n', '2019-10-07 14:53:07'),
(34, 16, 3, '&lt;p&gt;sdasasd&lt;/p&gt;\r\n', '2019-10-07 14:53:36');

-- --------------------------------------------------------

--
-- Table structure for table `crm_messages_users`
--

CREATE TABLE `crm_messages_users` (
  `ID` int(11) NOT NULL,
  `MessageID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Deleted` bit(1) NOT NULL DEFAULT b'0',
  `Is_Seen` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `crm_messages_users`
--

INSERT INTO `crm_messages_users` (`ID`, `MessageID`, `UserID`, `Deleted`, `Is_Seen`) VALUES
(11, 14, 3, b'0', b'0'),
(13, 15, 44, b'0', b'0'),
(15, 16, 47, b'0', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `crm_notifications`
--

CREATE TABLE `crm_notifications` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `crm_orders`
--

CREATE TABLE `crm_orders` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `transfer_id` int(11) DEFAULT NULL,
  `notes` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `crm_ordersettings`
--

CREATE TABLE `crm_ordersettings` (
  `ID` int(11) NOT NULL,
  `Text` varchar(255) NOT NULL,
  `Pro_Name` varchar(255) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `Is_Active` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `crm_ordersettings`
--

INSERT INTO `crm_ordersettings` (`ID`, `Text`, `Pro_Name`, `parent`, `Is_Active`) VALUES
(1, 'النوع', 'Type', NULL, b'1'),
(2, 'المنتج / الخدمة', 'Products', NULL, b'1'),
(3, 'الكميه', 'Quantity', NULL, b'1'),
(4, 'طريقه الشحن', 'Transfer', NULL, b'1'),
(5, 'منتج', 'product', 1, b'1'),
(6, 'خدمه', 'Service', 1, b'1'),
(7, 'طريقة الدفع', 'Payment', NULL, b'1'),
(8, 'المبلغ', 'Amount', NULL, b'0'),
(9, 'المبلغ المدفوع', 'Paid', 8, b'1'),
(10, 'المبلغ المتبقى', 'Remaining', 8, b'1'),
(11, 'حسابات التعاقد', 'Contracted', NULL, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `crm_permissions_objects`
--

CREATE TABLE `crm_permissions_objects` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crm_permissions_objects`
--

INSERT INTO `crm_permissions_objects` (`ID`, `Name`, `Code`) VALUES
(1, 'رفع ملفات', '01'),
(2, 'تقارير كاملة', '02'),
(3, 'تحميل قاعدة البيانات', '03'),
(4, 'الإعدادات', '04'),
(5, 'المكالمات الفائتة (لكل المستخدمين)', '05'),
(6, 'المكالمات القادمة (لكل المستخدمين)', '06'),
(7, 'إرسال إيميل + SMS', '07'),
(8, 'الموارد البشرية (الموظفين)', '08'),
(9, 'حالات العملاء (لكل المستخدمين)', '09'),
(10, 'الرسائل الداخلية + الشكاوى(لكل المستخدمين)', '10'),
(11, 'إستيراد + تعين مهام(لكل المستخدمين)', '11');

-- --------------------------------------------------------

--
-- Table structure for table `crm_products`
--

CREATE TABLE `crm_products` (
  `Product_ID` int(11) NOT NULL,
  `Product_Name` varchar(50) NOT NULL,
  `Product_Type` int(11) NOT NULL,
  `Price` int(11) DEFAULT '0',
  `Description` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `crm_products`
--

INSERT INTO `crm_products` (`Product_ID`, `Product_Name`, `Product_Type`, `Price`, `Description`) VALUES
(9, 'دليل تارجيت الاصدار الاول', 1, 100, NULL),
(10, 'دليل تارجيت الاصدار الثانى', 1, 150, NULL),
(11, 'سيريال', 2, 10, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `crm_sms`
--

CREATE TABLE `crm_sms` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ClientID` int(11) DEFAULT NULL,
  `Phone` varchar(50) NOT NULL,
  `MessageText` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `DeleteForEmployee` bit(1) NOT NULL DEFAULT b'0',
  `DeleteForSupervisor` bit(1) NOT NULL DEFAULT b'0',
  `DeleteForAdmin` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `crm_sms`
--

INSERT INTO `crm_sms` (`ID`, `UserID`, `ClientID`, `Phone`, `MessageText`, `Date`, `DeleteForEmployee`, `DeleteForSupervisor`, `DeleteForAdmin`) VALUES
(7, 45, 650, '201140218187', 'test SMS', '2019-10-07', b'1', b'0', b'0'),
(8, 45, 650, '201140218187', 'test SMS', '2019-10-07', b'0', b'0', b'0'),
(9, 45, 650, '201140218187', '123', '2019-10-07', b'0', b'0', b'0'),
(10, 45, 650, '201140218187', '654', '2019-10-07', b'1', b'0', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `crm_transfer_type`
--

CREATE TABLE `crm_transfer_type` (
  `transfer_ID` int(11) NOT NULL,
  `transfer_Name` varchar(50) NOT NULL,
  `Price` int(11) DEFAULT '0',
  `Description` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `crm_transfer_type`
--

INSERT INTO `crm_transfer_type` (`transfer_ID`, `transfer_Name`, `Price`, `Description`) VALUES
(7, 'إستلام بالشركة', 0, 'الاستلام من مقر الشركة'),
(8, 'مندوب الشركة', 50, 'التوصيل عن طريق مندوب لصالح الشركة'),
(9, 'شركة شحن', 60, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `crm_users`
--

CREATE TABLE `crm_users` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Gender` varchar(255) DEFAULT NULL,
  `BirthDate` date DEFAULT NULL,
  `Salary` int(11) DEFAULT NULL,
  `AnnInc` int(11) DEFAULT NULL,
  `SellInc` int(11) DEFAULT NULL,
  `JoinDate` date DEFAULT NULL,
  `UserName` varchar(255) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `Type` int(1) NOT NULL,
  `Super` int(11) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `num_message` int(11) NOT NULL DEFAULT '0',
  `Image` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crm_users`
--

INSERT INTO `crm_users` (`ID`, `Name`, `Email`, `Phone`, `Address`, `Gender`, `BirthDate`, `Salary`, `AnnInc`, `SellInc`, `JoinDate`, `UserName`, `Pass`, `Type`, `Super`, `active`, `num_message`, `Image`) VALUES
(3, 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin1', '827ccb0eea8a706c4c34a16891f84e7b', 1, NULL, 1, 30, 'admin.png'),
(44, 'هبه', 'abdob2623@gmail.com', '01114355330', 'test', NULL, '2010-02-02', 1, 1, 1, '2019-07-29', 'heba', '202cb962ac59075b964b07152d234b70', 2, NULL, 1, 10, 'heba.png'),
(45, 'منار', 'abdob2623@gmail.com2', '011143553302', 'test', NULL, '2010-02-02', 1, 1, 1, '2019-07-29', 'manar', '202cb962ac59075b964b07152d234b70', 3, 44, 1, 1, 'manar.jpg'),
(46, 'ريهام', 'abdob2623@gmail.com5', '011143553303', 'test', NULL, '2010-02-02', 1, 1, 1, '2019-07-01', 'reham', '202cb962ac59075b964b07152d234b70', 4, NULL, 0, 10, NULL),
(47, 'اسماء', 'abdob2623@gmail.com555', '011143553305', 'test', NULL, '2008-12-28', 1, 1, 1, '2019-07-02', 'asmaa', '202cb962ac59075b964b07152d234b70', 3, 44, 1, 10, NULL);

--
-- Triggers `crm_users`
--
DELIMITER $$
CREATE TRIGGER `SetUserPermissios` AFTER INSERT ON `crm_users` FOR EACH ROW INSERT INTO crm_users_permissions(UserID,Object_Code,IsGranted)

SELECT NEW.ID,crm_permissions_objects.Code,0
FROM crm_permissions_objects
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `crm_userstypes`
--

CREATE TABLE `crm_userstypes` (
  `ID` int(11) NOT NULL,
  `Name_EN` varchar(20) NOT NULL,
  `Name_AR` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `crm_userstypes`
--

INSERT INTO `crm_userstypes` (`ID`, `Name_EN`, `Name_AR`) VALUES
(1, 'Admin', 'مدير'),
(2, 'Supervisor', 'مشرف'),
(3, 'Employee', 'موظف'),
(4, 'Administrative', 'إدارى');

-- --------------------------------------------------------

--
-- Table structure for table `crm_users_log`
--

CREATE TABLE `crm_users_log` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Login_Time` datetime NOT NULL,
  `Last_Seen` datetime NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crm_users_log`
--

INSERT INTO `crm_users_log` (`ID`, `UserID`, `Login_Time`, `Last_Seen`, `Status`) VALUES
(1, 3, '0000-00-00 00:00:00', '2019-10-14 14:15:00', 1),
(12, 46, '0000-00-00 00:00:00', '2019-10-07 16:10:36', 2),
(13, 44, '0000-00-00 00:00:00', '2019-10-13 15:09:08', 2),
(14, 45, '0000-00-00 00:00:00', '2019-10-14 13:40:48', 2),
(15, 47, '0000-00-00 00:00:00', '2019-10-07 18:13:13', 2);

-- --------------------------------------------------------

--
-- Table structure for table `crm_users_permissions`
--

CREATE TABLE `crm_users_permissions` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Object_Code` varchar(50) NOT NULL,
  `IsGranted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crm_users_permissions`
--

INSERT INTO `crm_users_permissions` (`ID`, `UserID`, `Object_Code`, `IsGranted`) VALUES
(1, 3, '01', 1),
(2, 3, '02', 1),
(3, 3, '03', 1),
(4, 3, '04', 1),
(5, 3, '05', 1),
(6, 3, '06', 1),
(7, 3, '07', 1),
(8, 3, '08', 1),
(9, 3, '09', 1),
(258, 3, '10', 1),
(259, 3, '11', 1),
(549, 44, '01', 0),
(550, 44, '02', 0),
(551, 44, '03', 0),
(552, 44, '04', 0),
(553, 44, '05', 0),
(554, 44, '06', 0),
(555, 44, '07', 0),
(556, 44, '08', 0),
(557, 44, '09', 0),
(558, 44, '10', 0),
(559, 44, '11', 0),
(564, 45, '01', 1),
(565, 45, '02', 0),
(566, 45, '03', 0),
(567, 45, '04', 0),
(568, 45, '05', 0),
(569, 45, '06', 0),
(570, 45, '07', 1),
(571, 45, '08', 1),
(572, 45, '09', 0),
(573, 45, '10', 0),
(574, 45, '11', 0),
(579, 46, '01', 1),
(580, 46, '02', 1),
(581, 46, '03', 1),
(582, 46, '04', 1),
(583, 46, '05', 1),
(584, 46, '06', 1),
(585, 46, '07', 1),
(586, 46, '08', 1),
(587, 46, '09', 1),
(588, 46, '10', 1),
(589, 46, '11', 1),
(594, 47, '01', 0),
(595, 47, '02', 0),
(596, 47, '03', 0),
(597, 47, '04', 0),
(598, 47, '05', 0),
(599, 47, '06', 0),
(600, 47, '07', 0),
(601, 47, '08', 0),
(602, 47, '09', 0),
(603, 47, '10', 0),
(604, 47, '11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customercrm`
--

CREATE TABLE `customercrm` (
  `customerCrmId` int(11) NOT NULL,
  `addedby` int(11) NOT NULL,
  `customerCrmName` varchar(255) DEFAULT '',
  `customerCrmPhone` varchar(255) DEFAULT '',
  `customerCrmSecondPhone` varchar(255) DEFAULT NULL,
  `customerCrmEmail` varchar(255) DEFAULT NULL,
  `customerCrmCompany` varchar(255) DEFAULT NULL,
  `customerCrmGov` varchar(255) DEFAULT NULL,
  `customerCrmJob` varchar(255) DEFAULT NULL,
  `customerCrmQualification` varchar(255) DEFAULT NULL,
  `customerCrmCountry` varchar(255) DEFAULT NULL,
  `customerCrmAddress` varchar(255) DEFAULT NULL,
  `customerCrmAge` int(11) DEFAULT NULL,
  `customerCrmGender` bit(1) NOT NULL DEFAULT b'1' COMMENT '0 for male 1 for female',
  `customerCrmActivity` varchar(255) DEFAULT NULL,
  `customerCrmOther` varchar(255) DEFAULT NULL,
  `customerCrmCreateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customercrm`
--

INSERT INTO `customercrm` (`customerCrmId`, `addedby`, `customerCrmName`, `customerCrmPhone`, `customerCrmSecondPhone`, `customerCrmEmail`, `customerCrmCompany`, `customerCrmGov`, `customerCrmJob`, `customerCrmQualification`, `customerCrmCountry`, `customerCrmAddress`, `customerCrmAge`, `customerCrmGender`, `customerCrmActivity`, `customerCrmOther`, `customerCrmCreateDate`) VALUES
(642, 3, 'علي حمدان محمد حمدان', '201007238109', NULL, 'aiy_hemdan2009@yahoo.com', NULL, 'القاهرة', 'LLM Student', NULL, NULL, NULL, 26, b'0', 'فني حركة تحميل بشركة مصر للطيران', NULL, '2019-10-07 12:13:49'),
(643, 3, 'ايام انا دودا وبنعشها', '1231173013', NULL, 'dsdsds455@yahoo.com', NULL, 'القاهرة', 'Bc in business adm.', NULL, NULL, NULL, 27, b'0', 'كليه الاكاديميه البحريه', NULL, '2019-10-07 12:13:49'),
(644, 3, 'Basem Atef', '201144923824', NULL, 'tito_tito66014@gahoo.com', NULL, 'القاهرة', 'رجل اعمال', NULL, NULL, NULL, 28, b'1', 'مراقب جوده', NULL, '2019-10-07 12:13:49'),
(645, 3, 'Ahmed Eid', '201069603420', NULL, 'ahmedshebl22@yahoo.com', NULL, 'القاهرة', 'رقيب', NULL, NULL, NULL, 29, b'0', 'مهندس', NULL, '2019-10-07 12:13:49'),
(646, 3, 'محمود اسامه محمود', '201154909320', NULL, 'mahmoudosama00@yahoo.com', NULL, 'القاهرة', 'الكنترول', NULL, NULL, NULL, 30, b'0', 'Estudante', NULL, '2019-10-07 12:13:49'),
(647, 3, 'Mahmoud Eldsoke', '201227812421', NULL, 'mahmoudeldesoky717@yahoo.com', NULL, 'القاهرة', 'Associate director', NULL, NULL, NULL, 31, b'0', 'mahmod eldesoky', NULL, '2019-10-07 12:13:49'),
(648, 3, 'احمد محمد انور البنداري', '201004767770', NULL, 'abendary@gmail.com', NULL, 'القاهرة', 'Managing Partner', NULL, NULL, NULL, 32, b'0', 'مدير المراجعة علي تكنولوجيا المعلومات', NULL, '2019-10-07 12:13:49'),
(649, 3, 'Fathy Elaboudy', '201117727897', NULL, 'fffa244@yahoo.com', NULL, 'الجيزة', 'مهندس', NULL, NULL, NULL, 33, b'0', 'اعمال حره', NULL, '2019-10-07 12:13:49'),
(650, 3, 'حسام فوزى عبد العزيز', '01140218187', '', 'abdob2623@gmail.com', '', 'القاهرة', 'retired employee', '', '', '', 34, b'0', 'موظف حكومة', NULL, '2019-10-07 12:13:49'),
(651, 3, 'هاني ابو منه', '966541309211', NULL, 'abwmnh677@gmail.com', NULL, 'القاهرة', 'تسويق الكتروني', NULL, NULL, NULL, 35, b'0', 'رجل أعمال', NULL, '2019-10-07 12:13:49'),
(652, 3, 'اشرف مختار', '201025751519', NULL, 'mo_33_mo@yahoo.com', NULL, 'القاهرة', 'موظفه', NULL, NULL, NULL, 36, b'0', 'رئيس قسم الجودة', NULL, '2019-10-07 12:13:49'),
(653, 3, 'Hema Hema', '201000494270', NULL, 'hhema382@yahoo.com', NULL, 'القاهرة', 'government employee', NULL, NULL, NULL, 37, b'0', 'صحفي', NULL, '2019-10-07 12:13:49'),
(654, 3, 'بدر الدولى', '201007755618', NULL, 'badr_badr7@yahoo.com', NULL, 'القاهرة', 'Student', NULL, NULL, NULL, 38, b'1', 'ساحب عمل', NULL, '2019-10-07 12:13:49'),
(655, 3, 'علاء أحمد محمد حمد', '201006647556', NULL, 'alaahmad4675@gmail.com', NULL, 'الجيزة', 'ا.اميره فليفل', NULL, NULL, NULL, 39, b'0', 'معلم خبير', NULL, '2019-10-07 12:13:49'),
(656, 3, 'Seka Eltofan', '201118936880', NULL, 'fox_soso40@yahoo.com', NULL, 'القاهرة', 'رئيس مهندسين اقدم', NULL, NULL, NULL, 40, b'0', 'seka eltofan', NULL, '2019-10-07 12:13:49'),
(657, 3, 'Walid Yussef', '201144868925', NULL, 'wledommar@yahoo.com', NULL, 'القاهرة', 'm', NULL, NULL, NULL, 41, b'0', 'مترحفلات', NULL, '2019-10-07 12:13:49'),
(658, 3, 'Tarek Saied', '201222647409', NULL, 'rahafsd@yahoo.com', NULL, 'الجيزة', 'موظف', NULL, NULL, NULL, 42, b'0', 'معلم خبير فى اللغه عربيه', NULL, '2019-10-07 12:13:49'),
(659, 3, 'مجدى مجدى', '201274000931', NULL, 'magdy_magdymagdy@yahoo.com', NULL, 'القاهرة', 'مدرس', NULL, NULL, NULL, 43, b'0', 'إدارة', NULL, '2019-10-07 12:13:49'),
(660, 3, 'احمد حسن محمد حسين', '201021213090', NULL, 'abc_abc571@yahoo.com', NULL, 'القاهرة', 'Mechanicl Engneer', NULL, NULL, NULL, 44, b'0', 'صاحب محلات ملابس حريمى', NULL, '2019-10-07 12:13:49'),
(661, 3, 'فليمون عدلي لويز', '201208613575', NULL, 'philooflafelo@yahoo.com', NULL, 'القاهرة', 'اداري', NULL, NULL, NULL, 45, b'0', 'طالب', NULL, '2019-10-07 12:13:49'),
(662, 3, 'Ramy Eldashty', '201009853402', NULL, 'ramy.eldashty@yahoo.com', NULL, 'القاهرة', 'مهندس برمجيات', NULL, NULL, NULL, 46, b'0', 'حى مصر الجديده', NULL, '2019-10-07 12:13:49'),
(663, 3, 'احمد عابد حسن السيد وهدان', '201237836238', NULL, 'ahmedwahdan85@yahoo.com', NULL, 'الإسكندرية', 'Crisses Managment', NULL, NULL, NULL, 47, b'0', 'محامى حر', NULL, '2019-10-07 12:13:49'),
(664, 3, 'Emad Syam', '201005021410', NULL, 'mona.essa56@yahoo.com', NULL, 'المنوفية', 'مدرس', NULL, NULL, NULL, 48, b'1', 'محامى حر', NULL, '2019-10-07 12:13:49'),
(665, 3, 'أيمن مصطفي برهام', '1124454455', NULL, 'kemoov@gmail.com', NULL, 'القاهرة', 'ناشط ة في مجال حقوق الانسان', NULL, NULL, NULL, 49, b'0', 'طالب كليه الحقوق', NULL, '2019-10-07 12:13:49'),
(666, 3, 'Osama Mahran', '201111287323', NULL, 'osamaosamaosama220@yahoo.com', NULL, 'القاهرة', 'أعمال حره هندسه مدنيه', NULL, NULL, NULL, 50, b'0', 'وكيل النايب العام', NULL, '2019-10-07 12:13:49'),
(667, 3, 'Eslam Fooly', '201144947137', NULL, 'eslam_f19@yahoo.com', NULL, 'القاهرة', 'إداره اعمال الشركه', NULL, NULL, NULL, 51, b'0', 'مدرس مساعد', NULL, '2019-10-07 12:13:49'),
(668, 3, 'Hader Maged', '1018647232', NULL, 'hader.maged.a@gmail.com', NULL, 'القاهرة', 'معلمة', NULL, NULL, NULL, 52, b'0', 'حاصلة علي اعدادية ومكملتش لظروف خاصة وقتها وحاليا معايا لغة وباخد كورسات وبطور من مستوي التعليم بتاعي وبفهم ف حاجات كتير وبثقف نفسي بقراءة الكتب ومعرفة المعلومات عن كل شئ،ياريت لو في انترفيو للتأكد من صحة كلامي', NULL, '2019-10-07 12:13:49'),
(669, 3, 'Mohamed Ibrahim Kamel', '201227759851', NULL, 'Mohamednachintn@gmail.com', NULL, 'القاهرة', 'نزار الهجرسي', NULL, NULL, NULL, 53, b'0', 'Mohamed', NULL, '2019-10-07 12:13:49'),
(670, 3, 'Medhat Ramadan', '201001969033', NULL, 'abo.kadi84@gmail.com', NULL, 'الإسكندرية', 'اعلامي', NULL, NULL, NULL, 54, b'0', 'Administrative', NULL, '2019-10-07 12:13:49'),
(671, 3, 'UCant OwnMe', '201020240804', NULL, 'tarekrivaldo2000@gmail.com', NULL, 'القاهرة', 'بكلويوس قانون', NULL, NULL, NULL, 55, b'0', 'مشرف تدريب', NULL, '2019-10-07 12:13:49'),
(672, 3, 'Nader Kamal', '201223841844', NULL, 'nader_kimo2050@hotmail.com', NULL, 'القاهرة', 'هندسه مدينه', NULL, NULL, NULL, 56, b'0', 'Minister', NULL, '2019-10-07 12:13:49'),
(673, 3, 'Marco Megally Lale', '201225657336', NULL, 'marcolale@gmail.com', NULL, 'القاهرة', 'Chemical Engineer', NULL, NULL, NULL, 57, b'0', 'محامى', NULL, '2019-10-07 12:13:49'),
(674, 3, 'Eng Sarah Ibrahim', '201235832704', NULL, 'sarah_ibrahim9010@yahoo.com', NULL, 'الإسكندرية', 'مرشدة طلابية', NULL, NULL, NULL, 58, b'1', 'engineer', NULL, '2019-10-07 12:13:49'),
(675, 3, 'محمد عصمت عبدالمنعم', '201067502045', NULL, 'mohamd@yahoo.com', NULL, 'القاهرة', 'استاذ', NULL, NULL, NULL, 59, b'0', 'رئيس قضاء', NULL, '2019-10-07 12:13:49'),
(676, 3, 'Alaa Hikal', '1233400800', NULL, 'alaa141062alaa@gmil.com', NULL, 'القاهرة', 'national technical advisor', NULL, NULL, NULL, 60, b'0', 'CEO. for dana group co.', NULL, '2019-10-07 12:13:49'),
(677, 3, 'Ahmed Elkady', '1091802140', NULL, 'ahmed_sobhy123456@yahoo.com', NULL, 'القاهرة', 'مندوب مبيعات', NULL, NULL, NULL, 61, b'0', 'ثانويه عامه', NULL, '2019-10-07 12:13:49'),
(678, 3, 'Reda Omeira', '201001278193', NULL, 'Omeirareda@gmail.com', NULL, 'القاهرة', 'موظف اداري', NULL, NULL, NULL, 62, b'0', 'مستشار قضائي', NULL, '2019-10-07 12:13:49'),
(679, 3, 'Basem Farouk', '201239233138', NULL, 'basemfarok37@yahoo.com', NULL, 'الغربية', 'Manager', NULL, NULL, NULL, 63, b'0', 'مشرف جودة', NULL, '2019-10-07 12:13:49'),
(680, 3, 'عمرو مجدى فتحى عبده حمزه', '201062073610', NULL, 'amr.hamza37@yahoo.com', NULL, 'القاهرة', 'ادارة اعمال', NULL, NULL, NULL, 64, b'0', 'مدير (مصارعة محترفة)', NULL, '2019-10-07 12:13:49'),
(681, 3, 'Mahmoud Elashre', '201226376729', NULL, 'mahmoudelashre640@yahoo.com', NULL, 'القاهرة', 'ممهندس', NULL, NULL, NULL, 65, b'0', 'إدارة العمليات', NULL, '2019-10-07 12:13:49'),
(682, 3, 'Gehan Osman', '201226633055', NULL, 'gehanosman760@yahoo.com', NULL, 'القاهرة', 'حفار ابار مياه جوفيه', NULL, NULL, NULL, 66, b'0', 'مأمور تعريفة بجمارك اﻻسكندريه ( رئيس قسم تعريفه )', NULL, '2019-10-07 12:13:49'),
(683, 3, 'Môhãmêd Dãhßhâñ', '201270510014', NULL, 'mohamed2dahshan@yahoo.com', NULL, 'القاهرة', 'HR', NULL, NULL, NULL, 25, b'0', 'The owner of contracting company', NULL, '2019-10-07 12:13:49'),
(684, 3, 'Hamada Mahros Abo Gabl', '201226830088', NULL, 'motta_style@hotmail.com', NULL, 'القاهرة', 'ادارة', NULL, NULL, NULL, 26, b'1', 'سواق', NULL, '2019-10-07 12:13:49'),
(685, 3, 'أيهاب منصور أيهاب منصور', '201097999101', NULL, 'ehabmansour65@gmail.com', NULL, 'القاهرة', 'محامي', NULL, NULL, NULL, 27, b'0', 'محاسب ومراجع قانونى وصاحب مكتب محاسبة', NULL, '2019-10-07 12:13:49'),
(686, 3, 'عزالدين مكرم صديق حسن', '1096581311', NULL, 'Ezzair333@gmail.com', NULL, 'القاهرة', 'International Business Consultant', NULL, NULL, NULL, 28, b'0', 'مصر للطيران', NULL, '2019-10-07 12:13:49'),
(687, 3, 'Houda Hassan', '201239977513', NULL, 'h_mahmooud@yahoo.com', NULL, 'الإسكندرية', 'عضو فني جودة تعليم', NULL, NULL, NULL, 29, b'0', 'تاجر', NULL, '2019-10-07 12:13:49'),
(688, 3, 'Amged Ahmed', '201158366636', NULL, 'amged.ahmed888@gmail.com', NULL, 'القاهرة', 'Volunteering', NULL, NULL, NULL, 30, b'0', 'طالب حقوق', NULL, '2019-10-07 12:13:49'),
(689, 3, 'Amor Elamoor', '201205482986', NULL, 'asd.amr48@yahoo.com', NULL, 'القاهرة', 'own business', NULL, NULL, NULL, 31, b'0', 'Product Manager', NULL, '2019-10-07 12:13:49'),
(690, 3, 'لمياء إبراهيم رشوان', '201096941172', NULL, 'marwaokasha@gmail.com', NULL, 'الشرقية', 'اداره اعمال', NULL, NULL, NULL, 32, b'0', 'خريجه بكالريوس تمريض', NULL, '2019-10-07 12:13:49'),
(691, 3, 'فايز مرسى', '201226622785', NULL, 'aboyousef941@yahoo.com', NULL, 'القاهرة', 'Businessperson', NULL, NULL, NULL, 33, b'0', 'مركز معلومات ودعم اتخاذ القرار', NULL, '2019-10-07 12:13:49'),
(692, 3, 'Medhat Nagy El Nagy', '201156059416', NULL, 'medhatz_agram@yahoo.com', NULL, 'القاهرة', 'نظم معلومات اداريه', NULL, NULL, NULL, 34, b'0', 'موظف  اداري', NULL, '2019-10-07 12:13:49'),
(693, 3, 'الصلاة على النبى', '201028200522', NULL, 'mahasaad23@gmail.com', NULL, 'القاهرة', 'manger computer', NULL, NULL, NULL, 35, b'0', 'معلم اول بالتربية والتعليم', NULL, '2019-10-07 12:13:49'),
(694, 3, 'Mohammed Asfour', '201207445552', NULL, 'asfourlove98@yahoo.com', NULL, 'بورسعيد', 'Lecturer', NULL, NULL, NULL, 36, b'1', 'محمد حسام الدين مصطفى يسري عصفور', NULL, '2019-10-07 12:13:49'),
(695, 3, 'أميرالسيدعبدالنطلب ابوالخير', '1003137480', NULL, 'abosalma_net@yahoo.com', NULL, 'بورسعيد', 'عامل الحرية', NULL, NULL, NULL, 37, b'0', 'فني بشركة مياة الشرب والصرف الصحي', NULL, '2019-10-07 12:13:49'),
(696, 3, 'Samir Sabry', '1003131872', NULL, 'sm_sm_82@yahoo.com', NULL, 'المنوفية', 'ادارة المراجعة المالية', NULL, NULL, NULL, 38, b'0', 'حاصل على ليسانس شريعة و قانون', NULL, '2019-10-07 12:13:49'),
(697, 3, 'سمر ياسر عبد اللطيف', '1141656681', NULL, 'samarf16@yahoo.com', NULL, 'الجيزة', 'مدير مشاريع الهيئة', NULL, NULL, NULL, 39, b'0', 'لا يوجد', NULL, '2019-10-07 12:13:49'),
(698, 3, 'zakaria tarek mohamed', '1023225582', NULL, 'torky_22000@yahoo.com', NULL, 'القاهرة', 'لا اعمل', NULL, NULL, NULL, 40, b'0', 'مستشار', NULL, '2019-10-07 12:13:49'),
(699, 3, 'Mahmood Al-dulaimi', '9647302057066', NULL, 'm_shhab@yahoo.com', NULL, 'القاهرة', 'Product Manager', NULL, NULL, NULL, 41, b'0', 'مدير حسابات', NULL, '2019-10-07 12:13:49'),
(700, 3, 'Ahmed Sedky Elzanaty', '201014280586', NULL, 'Ahmed.elzanaty83@yahoo.com', NULL, 'العاشر من رمضان', 'D.M.', NULL, NULL, NULL, 42, b'0', 'اكاديميه الشرطه كليه الشرطه', NULL, '2019-10-07 12:13:49'),
(701, 3, 'كارم محمود محمد المصرى', '966541959427', NULL, 'karamelmasry@gimal.com', NULL, 'الشرقية', 'مسؤال علاقات عامه', NULL, NULL, NULL, 43, b'0', 'فورمن', NULL, '2019-10-07 12:13:49'),
(702, 3, 'Hany Shahein', '201022488673', NULL, 'top2fiber@hotmail.com', NULL, 'القاهرة', 'رئيس ملاحظين', NULL, NULL, NULL, 44, b'0', 'مدير', NULL, '2019-10-07 12:13:49'),
(703, 3, 'Yasser Sayd', '201272086098', NULL, 'yasser.sayd@gmail.com', NULL, 'الجيزة', 'Nothing', NULL, NULL, NULL, 45, b'0', 'هندسة تطبيقية', NULL, '2019-10-07 12:13:49'),
(704, 3, 'ياسر احمد السيد احمد', '201099254239', NULL, 'ahmed.yasser572@yahoo.com', NULL, 'القاهرة', 'executive secertary', NULL, NULL, NULL, 46, b'1', 'مندوب عام', NULL, '2019-10-07 12:13:49'),
(705, 3, 'محمد رجب البروكي', '201230161379', NULL, 'mmrr719@gamil.com', NULL, 'القاهرة', 'Assistent Engineer', NULL, NULL, NULL, 47, b'0', 'معلم', NULL, '2019-10-07 12:13:49'),
(706, 3, 'احمد محمد سيد', '201201962469', NULL, 'qanasalwa89@yahoo.com', NULL, 'الدقهلية', 'bachlor of physics', NULL, NULL, NULL, 48, b'0', 'مشرف ادارى', NULL, '2019-10-07 12:13:49'),
(707, 3, 'Soad Rageh', '1092412111', NULL, 'sososer.22@gmail.com', NULL, 'القاهرة', 'لايوجد', NULL, NULL, NULL, 49, b'0', 'lawer', NULL, '2019-10-07 12:13:49'),
(708, 3, 'Ibrahim mohammed saad hirby', '201148207067', NULL, 'ibrahim.hirby@gmail.com', NULL, 'القاهرة', 'مدرس', NULL, NULL, NULL, 50, b'0', 'chef Dibrty', NULL, '2019-10-07 12:13:49'),
(709, 3, 'Farhat Alaebaidy Mohammed', '1156046869', NULL, 'farhatmohamed74@yahoo.com', NULL, 'القاهرة', 'ناشط شبابي', NULL, NULL, NULL, 51, b'0', 'مدير مالي', NULL, '2019-10-07 12:13:49'),
(710, 3, 'احمد عزالدين حسن', '201118351111', NULL, 'ahmed_ezz_ezz@live.com', NULL, 'القاهرة', 'عليه محمد مهوس', NULL, NULL, NULL, 52, b'0', 'ahmed ezz', NULL, '2019-10-07 12:13:49'),
(711, 3, 'Ramiz Yossef', '201065511104', NULL, 'mizoo_mozaa@yahoo.com', NULL, 'الغربية', 'RT', NULL, NULL, NULL, 53, b'0', 'Accountant', NULL, '2019-10-07 12:13:49'),
(712, 3, 'موسى فتح الله كريم عبدالعال', '201000277053', NULL, 'anamoaz153@yahoo.com', NULL, 'القاهرة', 'اداري', NULL, NULL, NULL, 54, b'0', 'صاحب مكتب استيراد وتصدير', NULL, '2019-10-07 12:13:49'),
(713, 3, 'Ahmed Ibraheem', '201230481650', NULL, 'ahmed.ibraheem93@yahoo.com', NULL, 'الجيزة', 'صيدلية التأمين الحى', NULL, NULL, NULL, 55, b'0', 'محام', NULL, '2019-10-07 12:13:49'),
(714, 3, 'Mohamed mahmoud', '201025368666', NULL, 'modydanger@hotmail.com', NULL, 'القاهرة', 'طالبه', NULL, NULL, NULL, 56, b'1', 'Business owner', NULL, '2019-10-07 12:13:49'),
(715, 3, 'احمد سمير السيد', '201156498242', NULL, 'ahmedsamir808@yahoo.com', NULL, 'القاهرة', 'مرشد سياحي', NULL, NULL, NULL, 57, b'0', 'احدى شركات الكهرباء', NULL, '2019-10-07 12:13:49'),
(716, 3, 'هاني موريس', '1204487976', NULL, 'jloveme30@yahoo.com', NULL, 'الإسكندرية', 'اداره اعمال', NULL, NULL, NULL, 58, b'0', 'فني اسنان', NULL, '2019-10-07 12:13:49'),
(717, 3, 'abduallah ismail', '0', NULL, 'abduallah_mohammed@hotmail.com', NULL, 'الجيزة', 'Jordan', NULL, NULL, NULL, 59, b'0', 'محامي', NULL, '2019-10-07 12:13:49'),
(718, 3, 'Basem Helmy', '1000112294', NULL, 'basem7elmy@yahoo.com', NULL, 'القاهرة', 'Branch Manager Pizza Hut in Saudi Arabia', NULL, NULL, NULL, 60, b'0', 'Site Engineer', NULL, '2019-10-07 12:13:49'),
(719, 3, 'Mahmoud Elshrnoby', '201025044704', NULL, 'mm_elshrnoby@yahoo.com', NULL, 'القاهرة', 'chef', NULL, NULL, NULL, 61, b'0', 'محامي', NULL, '2019-10-07 12:13:49'),
(720, 3, 'علي محمد محمد عبد العزيز', '201006585309', NULL, 'wwwwwww4568@yahoo.com', NULL, 'الجيزة', 'Organizational things', NULL, NULL, NULL, 62, b'0', 'مستشار', NULL, '2019-10-07 12:13:49'),
(721, 3, 'Mohamed Mahmoud', '201231765651', NULL, 'memo_2022l@yahoo.com', NULL, 'القاهرة', 'احصائي', NULL, NULL, NULL, 63, b'0', 'محاسب', NULL, '2019-10-07 12:13:49'),
(722, 3, 'محمد البحيری', '201005855074', NULL, 'mido_tiger3073@yahoo.com', NULL, 'الغربية', 'مدير أقدم', NULL, NULL, NULL, 64, b'0', 'طالب', NULL, '2019-10-07 12:13:49'),
(723, 3, 'أّبِوِبكرعٌبِدِأّلَنِبِيِّ مَحٌمَدِعٌلَيِّ زغاليل', '201016024165', NULL, 'abobkr_love46@yahoo.com', NULL, 'القاهرة', 'ادارة اعمال', NULL, NULL, NULL, 65, b'0', 'حٌأّصلَ عٌلَيِّ دِبِلَوِمَ تّجِأّرهٌِ', NULL, '2019-10-07 12:13:49'),
(724, 3, 'مہصہريہ شہيہكہ', '201156252983', NULL, 'alaaeslam421@gmail.com', NULL, 'القاهرة', 'محامى', NULL, NULL, NULL, 66, b'1', 'متابع من قبل99,902,418,998 شخصًا', NULL, '2019-10-07 12:13:49'),
(725, 3, 'Mahmoud Abd El Rahman', '1064077675', NULL, 'anaelmajic200@yahoo.com', NULL, 'الجيزة', 'Civil Engineer', NULL, NULL, NULL, 25, b'0', 'طالب حقوق', NULL, '2019-10-07 12:13:49'),
(726, 3, 'على مصطفى', '201010094128', NULL, 'a01010094123@gmail.com', NULL, 'الجيزة', 'إلإدارة مالية و المصرفية', NULL, NULL, NULL, 26, b'0', 'لا اعمل', NULL, '2019-10-07 12:13:49'),
(727, 3, 'Amal Ahmed', '1100360212', NULL, 'molaeng84@yahoo.com', NULL, 'القاهرة', 'بكالوريوس ادارة اعمال', NULL, NULL, NULL, 27, b'0', 'مهندس حره.... حاصله على بكالريوس  هندسه كيميائية ونوويه', NULL, '2019-10-07 12:13:49'),
(728, 3, 'Mouhamed Mohsen', '201010327783', NULL, 'mouhamedmohsen92@gmail.com', NULL, 'القاهرة', 'Sr. Supervisor', NULL, NULL, NULL, 28, b'0', 'Chemical Tester', NULL, '2019-10-07 12:13:49'),
(729, 3, 'عمر قدرى', '201021853594', NULL, 'kadryo088@gmil.com', NULL, 'الشرقية', 'الشركة العامة لإدارة النقل الخاص', NULL, NULL, NULL, 29, b'0', 'عاطل', NULL, '2019-10-07 12:13:49'),
(730, 3, 'Mohamed Ali Mohamed Ali Elsaeidy', '201208107971', NULL, 'engineer.emg2@gmail.com', NULL, 'القاهرة', 'forman', NULL, NULL, NULL, 30, b'0', 'مدير قسم الزراعة', NULL, '2019-10-07 12:13:49'),
(731, 3, 'Hassan Mohamed', '201121115165', NULL, 'hassan.mohamed3040@yahoo.com', NULL, 'القاهرة', 'Secretary', NULL, NULL, NULL, 31, b'0', 'مستشار', NULL, '2019-10-07 12:13:50'),
(732, 3, 'Ôshà Ôshâ', '1025807919', NULL, 'sh.adel18@yahoo.com', NULL, 'القاهرة', 'مدير تنفيذي', NULL, NULL, NULL, 32, b'0', 'مَعٌ أّصٌحٌأّبِيِّ', NULL, '2019-10-07 12:13:50'),
(733, 3, 'صبحي فراح احمد حرب', '201065702175', NULL, 'sobhy.harb@yahoo.com', NULL, 'القاهرة', 'طالبه', NULL, NULL, NULL, 33, b'0', 'ثانوية ازهرية', NULL, '2019-10-07 12:13:50'),
(734, 3, 'محمد الدكروني', '201211388677', NULL, 'mohamedmidoo473@yahoo.com', NULL, 'القاهرة', 'مدربة تنمية بشرية', NULL, NULL, NULL, 34, b'1', 'لسه شويه', NULL, '2019-10-07 12:13:50'),
(735, 3, 'حودة الرماح', '201270007344', NULL, 'nadaahmed5066@yahoo.com', NULL, 'القاهرة', 'University Professor', NULL, NULL, NULL, 35, b'0', 'شركة كهرباء الاسكندرية', NULL, '2019-10-07 12:13:50'),
(736, 3, 'Mohamed Figo', '201150005853', NULL, 'figo_figo7333@yahoo.com', NULL, 'الجيزة', 'استشاري مبيعات', NULL, NULL, NULL, 36, b'0', 'General Manager', NULL, '2019-10-07 12:13:50'),
(737, 3, 'محمد عبد الخالق', '201027222161', NULL, 'abd_elkhalek85@yahoo.com', NULL, 'القاهرة', 'accountant', NULL, NULL, NULL, 37, b'0', 'بكالريوس خدمة اجتماعية', NULL, '2019-10-07 12:13:50'),
(738, 3, 'Osama Hassan', '201128078464', NULL, 'osamamano13@yahoo.com', NULL, 'القاهرة', 'محاسب اقدم', NULL, NULL, NULL, 38, b'0', 'علاقات عامه', NULL, '2019-10-07 12:13:50'),
(739, 3, 'Dode Idrees', '201099711960', NULL, 'daliadod35@yahoo.com', NULL, 'الغربية', 'لا اعمل', NULL, NULL, NULL, 39, b'0', 'محاميه', NULL, '2019-10-07 12:13:50'),
(740, 3, 'Adel Ashmawy', '201008933626', NULL, 'AdelAshmawy3302@gamil.com', NULL, 'القاهرة', 'Pharmacist', NULL, NULL, NULL, 40, b'0', 'كبير سائقين ببنك مصر', NULL, '2019-10-07 12:13:50'),
(741, 3, 'islam gamal el-Den saad ali', '1150009632', NULL, 'jaguerpaw25@gmail.com', NULL, 'الإسكندرية', 'رئسية وحدة ادخال', NULL, NULL, NULL, 41, b'0', 'super visor @orouba misr', NULL, '2019-10-07 12:13:50'),
(742, 3, 'آبو شهد عبدة العشماوي', '201092188520', NULL, 'mr444555@yahoo.com', NULL, 'القاهرة', 'Designer', NULL, NULL, NULL, 42, b'0', '&lt; خط &gt;  &lt; النار &gt;', NULL, '2019-10-07 12:13:50'),
(743, 3, 'Mido Mostafa', '201095753166', NULL, 'mohamed_love8206@yahoo.com', NULL, 'القاهرة', 'teacher', NULL, NULL, NULL, 43, b'0', 'موظف لدى جهاز مشروعات الخدمه الوطنيه', NULL, '2019-10-07 12:13:50'),
(744, 3, 'على أبو على', '201020074411', NULL, 'mr_ali90@yahoo.com', NULL, 'القليوبية', 'مستشار مالي', NULL, NULL, NULL, 44, b'1', 'رجل أعمال', NULL, '2019-10-07 12:13:50'),
(745, 3, 'عبد الحميدمحمد عبدالحليم احمد بدر الديب', '201000509916', NULL, 'amedo2226@yahoo.com', NULL, 'العاشر من رمضان', 'صاحب الشركة', NULL, NULL, NULL, 45, b'0', 'معلم اول ا', NULL, '2019-10-07 12:13:50'),
(746, 3, 'Moamen Mohamed', '1028870771', NULL, 'hemamomen@yahoo.com', NULL, 'القاهرة', 'ممرض', NULL, NULL, NULL, 46, b'0', 'مدير', NULL, '2019-10-07 12:13:50'),
(747, 3, 'هانى عبدالعزيز عطعوط', '201001854750', NULL, 'hanyabdelaziz81@yahoo.com', NULL, 'مدينة 6 أكتوبر', 'مدير مكتب المراقب المالي', NULL, NULL, NULL, 47, b'0', 'محامى', NULL, '2019-10-07 12:13:50'),
(748, 3, 'جاد جاد', '1121677710', NULL, 'gadgad689@gimal.com', NULL, 'الجيزة', 'طالب', NULL, NULL, NULL, 48, b'0', 'محام', NULL, '2019-10-07 12:13:50'),
(749, 3, 'ابراهيم عبدالرحمن محمد مصطفي', '201002673750', NULL, 'ibrahim.miligy.86@gmail.com', NULL, 'القاهرة', 'صاحب مؤسسة تجارية', NULL, NULL, NULL, 49, b'0', 'حاصل ع دبلو تجاره', NULL, '2019-10-07 12:13:50'),
(750, 3, 'مصطفى محمد مهران', '201159561558', NULL, 'mostafa.mohran@gmail.com', NULL, 'القاهرة', 'مدير تدقيق اقدم', NULL, NULL, NULL, 50, b'0', 'مفتش صحة ومأمور ضبط قضائي', NULL, '2019-10-07 12:13:50'),
(751, 3, 'Mohamed fathy ahmed mohamed', '1000185951', NULL, 'assetsco@yahoo.com', NULL, 'القاهرة', 'Office manager', NULL, NULL, NULL, 51, b'0', 'chairman of assets of trading and contracting', NULL, '2019-10-07 12:13:50'),
(752, 3, 'احمد البحيري', '201210266807', NULL, 'aelbhery50@gmail.com', NULL, 'المنوفية', 'ادارة اعمال', NULL, NULL, NULL, 52, b'0', 'ضابط جيش قوات خاصه', NULL, '2019-10-07 12:13:50'),
(753, 3, 'Hisham Yousef', '201115514499', NULL, 'hisham_yousef@hotmail.com', NULL, 'القاهرة', 'occupational therapist', NULL, NULL, NULL, 53, b'0', 'Police Officer', NULL, '2019-10-07 12:13:50'),
(754, 3, 'Ramy Saad', '201233867793', NULL, 'ramysaad1234@yahoo.com', NULL, 'القاهرة', 'مدير', NULL, NULL, NULL, 54, b'1', 'معلم مساعد', NULL, '2019-10-07 12:13:50'),
(755, 3, 'Mido King', '201112835798', NULL, 'midoking1155@yahoo.com', NULL, 'القاهرة', 'موظفة . محاسبة', NULL, NULL, NULL, 55, b'0', 'محامى', NULL, '2019-10-07 12:13:50'),
(756, 3, 'Marwa Abdallah', '201277204648', NULL, 'loka_com2000@yahoo.com', NULL, 'القاهرة', 'رئيس وزراء سابقآ', NULL, NULL, NULL, 56, b'0', 'محامية حرة', NULL, '2019-10-07 12:13:50'),
(757, 3, 'اشرف كدوانى', '201061090222', NULL, 'kedwany2@yahoo.com', NULL, 'الجيزة', 'mihamed', NULL, NULL, NULL, 57, b'0', 'رئيس قسم التحقيقات', NULL, '2019-10-07 12:13:50'),
(758, 3, 'Mahmoud sobhi saif elnasr', '201024427675', NULL, 'mah_saif.2010@yahoo.com', NULL, 'الجيزة', 'محاسبة', NULL, NULL, NULL, 58, b'0', 'engineer', NULL, '2019-10-07 12:13:50'),
(759, 3, 'Mohamed Samir Eissa', '201226809809', NULL, 'm.samir5890@yahoo.com', NULL, 'الجيزة', 'موظف اداري بالشركة العامة للكهرباء', NULL, NULL, NULL, 59, b'0', 'Advertising Director', NULL, '2019-10-07 12:13:50'),
(760, 3, 'Hossam Ramzy', '201141430402', NULL, 'hero.lovers@yahoo.com', NULL, 'الإسكندرية', 'اداره صيانه', NULL, NULL, NULL, 60, b'0', 'مدرس حاســـب الى', NULL, '2019-10-07 12:13:50'),
(761, 3, 'Magda Abdo', '201002922299', NULL, 'magdaabdo72@yahoo.com', NULL, 'القاهرة', 'MBA', NULL, NULL, NULL, 61, b'0', 'معلم خبير بوزارة التربية والتعليم', NULL, '2019-10-07 12:13:50'),
(762, 3, 'محمد شكر', '201001319503', NULL, 'mohamedshokr88@gmail.com', NULL, 'الجيزة', 'استاذ ثانوي', NULL, NULL, NULL, 62, b'0', 'حارس ببنك التنميه', NULL, '2019-10-07 12:13:50'),
(763, 3, 'Mohammed Ibrahim', '201231719803', NULL, 'mohammedbon1989@yahoo.com', NULL, 'القاهرة', 'District Manager', NULL, NULL, NULL, 63, b'0', 'مشغل أجهزة بتروليه', NULL, '2019-10-07 12:13:50'),
(764, 3, 'Mostafa Marey', '201060694005', NULL, 'mostafa.marey@hotmail.com', NULL, 'القاهرة', 'ربة منزل', NULL, NULL, NULL, 64, b'1', 'Electrcal engineer', NULL, '2019-10-07 12:13:50'),
(765, 3, 'مصطفى محمد مصدق', '201221215292', NULL, 'dream_x87@yahoo.com', NULL, 'القاهرة', 'Prisedent', NULL, NULL, NULL, 65, b'0', 'أخصائي اجتماعي', NULL, '2019-10-07 12:13:50'),
(766, 3, 'بتقول تعبتك ادينى سبتك', '201223664698', NULL, 'badrmohamd478@gmail.com', NULL, 'القاهرة', 'pharmacist', NULL, NULL, NULL, 66, b'0', 'فني تشغيل', NULL, '2019-10-07 12:13:50'),
(767, 3, 'Shereen Abdelgwad', '1025494551', NULL, 'shereens628@gmail.com', NULL, 'الإسكندرية', 'Graduate Assistant', NULL, NULL, NULL, 25, b'0', 'محامي', NULL, '2019-10-07 12:13:50'),
(768, 3, 'Ahmed khalaf mohamed', '1273218989', NULL, 'Wineergroup6@gmail.com', NULL, 'الجيزة', 'محاضر', NULL, NULL, NULL, 26, b'0', 'رئيس مجلس الاداره', NULL, '2019-10-07 12:13:50'),
(769, 3, 'Wael Ramdan', '201225846636', NULL, 'waelramdan53@yahoo.com', NULL, 'القاهرة', 'محاسب', NULL, NULL, NULL, 27, b'0', 'محاسب', NULL, '2019-10-07 12:13:50'),
(770, 3, 'ميرو شلبي', '201016493602', NULL, 'mahershalpy@Yahoo.com', NULL, 'الجيزة', 'Petroleum Engineer', NULL, NULL, NULL, 28, b'0', 'وزير العدل', NULL, '2019-10-07 12:13:50'),
(771, 3, 'Roaa Amar', '1146537710', NULL, 'bosekat14@yahoo.com', NULL, 'الإسكندرية', 'خريجة كلية تربية قسم لغة إنجليزية', NULL, NULL, NULL, 29, b'0', 'طالب بكلية حقوق', NULL, '2019-10-07 12:13:50'),
(772, 3, 'محمد حسين', '201223754557', NULL, 'drmody292@yahoo.com', NULL, 'القاهرة', 'خريج', NULL, NULL, NULL, 30, b'0', 'وزارة الموارد المائيه', NULL, '2019-10-07 12:13:50'),
(773, 3, 'كرم عبده', '201212777910', NULL, 'karamapdo2020@gmile.com', NULL, 'الجيزة', 'مندوب مبيعات', NULL, NULL, NULL, 31, b'0', 'محاسب شركة المتحدون لصناعة النسيج والملابس الجاهزة', NULL, '2019-10-07 12:13:50'),
(774, 3, 'احمد عادل معوض فراج', '201023018189', NULL, 'ahmed.adelfarag@yahoo.com', NULL, 'القاهرة', 'eng', NULL, NULL, NULL, 32, b'1', 'رئيس قسم بالشركة المصرية لنقل وتوصيل الغاز (بوتاجاسكو)', NULL, '2019-10-07 12:13:50'),
(775, 3, 'Osama Ibra Him', '201013820069', NULL, 'usama_shaban@hotmail.com', NULL, 'القاهرة', 'مهندس سوفت + هارد وير هواتف نقالة', NULL, NULL, NULL, 33, b'0', 'مدير ادارة', NULL, '2019-10-07 12:13:50'),
(776, 3, 'وفاء عبد المنعم عبد الفتاح شهاب الدين', '1275068925', NULL, 'wafaa3698@gmail.com', NULL, 'القاهرة', 'موظف', NULL, NULL, NULL, 34, b'0', 'طالب', NULL, '2019-10-07 12:13:50'),
(777, 3, 'امين زكريا امين عيد الشال', '201229578098', NULL, 'mhmodei@yahoo.com', NULL, 'القاهرة', 'ادارة اعمال', NULL, NULL, NULL, 35, b'0', 'مدرس', NULL, '2019-10-07 12:13:50'),
(778, 3, 'Mohamed Ali', '201212704353', NULL, 'Mohamed.113976@gmail.com', NULL, 'الجيزة', 'Administration manager', NULL, NULL, NULL, 36, b'0', 'طالب بالصف الثالث بالخدمة الاجتماعية كفر صقر', NULL, '2019-10-07 12:13:50'),
(779, 3, 'السيد شويل', '201011100085', NULL, 'abo.ammar2014@yahoo.com', NULL, 'الجيزة', 'projects manager', NULL, NULL, NULL, 37, b'0', 'دبلوم صنايع', NULL, '2019-10-07 12:13:50'),
(780, 3, 'عبد السميع عطيه عبد السميع', '201004663843', NULL, 'abdo.atia17@yahoo.com', NULL, 'القاهرة', 'مديره المركز وخبيره التجميل', NULL, NULL, NULL, 38, b'0', 'مفتش مالى وادارى بمديرية الشباب والرياضة بدمياط', NULL, '2019-10-07 12:13:50'),
(781, 3, 'زهرة العلا', '201024317634', NULL, 'ola_198040@yahoo.com', NULL, 'القاهرة', 'رئيس تحرير مجلة الحلم الجديد', NULL, NULL, NULL, 39, b'0', 'محاسبه قسم اداره اعمال', NULL, '2019-10-07 12:13:50'),
(782, 3, 'Ghada Elshabrawy', '1000939483', NULL, 'prensses.2011@yahoo.com', NULL, 'القاهرة', 'صرافه', NULL, NULL, NULL, 40, b'0', 'Marketing Manager', NULL, '2019-10-07 12:13:50'),
(783, 3, 'Mostafa mohsen Mustafa', '201114000541', NULL, 'mostafamsasa45@yahoo.com', NULL, 'القاهرة', 'طالب', NULL, NULL, NULL, 41, b'0', 'ظابط شرطي', NULL, '2019-10-07 12:13:50'),
(784, 3, 'احمد خيري محمد', '201149012115', NULL, 'ahmed.almakawe@yahoo.com', NULL, 'القاهرة', 'Project Manager', NULL, NULL, NULL, 42, b'1', 'مستشار في التحكيم الدولي', NULL, '2019-10-07 12:13:50'),
(785, 3, 'Mohamed Fathy', '201226266623', NULL, 'm.a.fathy@gmail.com', NULL, 'القاهرة', 'مدير عام الشركة', NULL, NULL, NULL, 43, b'0', 'HSE Manager', NULL, '2019-10-07 12:13:50'),
(786, 3, 'Mostafa Nabih', '201006627101', NULL, 'sasa22_2009@yahoo.com', NULL, 'الدقهلية', 'رئيس ملاحظين', NULL, NULL, NULL, 44, b'0', 'محامي', NULL, '2019-10-07 12:13:50'),
(787, 3, 'اسير العيون اسير العيون', '201223605579', NULL, 'totalove201048@yahoo.com', NULL, 'الشرقية', 'مدير اعمال', NULL, NULL, NULL, 45, b'0', 'فني وساءل تعليميه', NULL, '2019-10-07 12:13:50'),
(788, 3, 'محمد جمال قاسم عبد الرازق شليوة', '1068199800', NULL, 'ali277@yahoo.com', NULL, 'الإسكندرية', 'موظف حكومي', NULL, NULL, NULL, 46, b'0', 'صاحب مصنع ملابس', NULL, '2019-10-07 12:13:50'),
(789, 3, 'Al Lourd', '201064223166', NULL, 'legaladvisor02@gmail.com', NULL, 'الإسكندرية', 'مدرس', NULL, NULL, NULL, 47, b'0', 'مستشار قانونى', NULL, '2019-10-07 12:13:50'),
(790, 3, 'Ahmed Shohaib', '201140233455', NULL, 'drbka_88@yahoo.com', NULL, 'الإسكندرية', 'مستشار تحكيم دولي', NULL, NULL, NULL, 48, b'0', 'كاشير', NULL, '2019-10-07 12:13:50'),
(791, 3, 'Abeer Yousef Ismael', '201063582583', NULL, 'yabeer666@yahoo.com', NULL, 'القاهرة', 'استاذ ه رياضيات', NULL, NULL, NULL, 49, b'0', 'موجه عام', NULL, '2019-10-07 12:13:50'),
(792, 3, 'الحاج حسن المقدم', '201114567852', NULL, 'hassn_100035@yahoo.com', NULL, 'الجيزة', 'كاسب', NULL, NULL, NULL, 50, b'0', 'تاجر اكسسوار محمول', NULL, '2019-10-07 12:13:50'),
(793, 3, 'منتصر الشاهيني لعبيدي', '201016278220', NULL, 'egmontaser@g.com', NULL, 'القاهرة', 'مسؤول شعبة', NULL, NULL, NULL, 51, b'0', 'مهندس برمجيات', NULL, '2019-10-07 12:13:50'),
(794, 3, 'عماد حمدي', '201026327580', NULL, 'emadhamdi95@hotmail.com', NULL, 'القاهرة', 'مدير حسابات', NULL, NULL, NULL, 52, b'1', 'أخصائي بصريات', NULL, '2019-10-07 12:13:50'),
(795, 3, 'Sayed Mohammed', '1002871351', NULL, 'sayed.mohammed61@yahoo.com', NULL, 'القاهرة', 'مهندس مشرف عام ميكانيكي', NULL, NULL, NULL, 53, b'0', 'مشرف حركه  ومسئول ترخيص', NULL, '2019-10-07 12:13:50'),
(796, 3, 'Ahmed Mokhtar Mokh', '201010200079', NULL, 'helm.hayate@yahoo.com', NULL, 'القاهرة', 'اداراة اعمال', NULL, NULL, NULL, 54, b'0', 'طالب', NULL, '2019-10-07 12:13:50'),
(797, 3, 'محمود احمد اسماعيل', '201158020683', NULL, 'bebolove202060@yahoo.com', NULL, 'القليوبية', 'مدير فني اقدم', NULL, NULL, NULL, 55, b'0', 'طالب', NULL, '2019-10-07 12:13:50'),
(798, 3, 'مهنى عبدالعاطى مهنى أحمد', '201098250101', NULL, 'mehani@yahoo.com', NULL, 'القاهرة', 'ngner', NULL, NULL, NULL, 56, b'0', 'مهندس كهرباء', NULL, '2019-10-07 12:13:50'),
(799, 3, 'Mohamed Salem', '201234228080', NULL, 'vip_prosecutre@yahoo.com', NULL, 'القاهرة', 'اختصاصي تسويق', NULL, NULL, NULL, 57, b'0', 'محامى', NULL, '2019-10-07 12:13:50'),
(800, 3, 'Ayman Awny', '201010505017', NULL, 'aymanresat@yahoo.com', NULL, 'القاهرة', 'مدير ادارة الدراسات والقروض', NULL, NULL, NULL, 58, b'0', 'General Manager', NULL, '2019-10-07 12:13:50'),
(801, 3, 'رضا ووشو', '201126700766', NULL, 'r_woosho_1977@yahoo.com', NULL, 'القاهرة', 'طالب ثم مدرس', NULL, NULL, NULL, 59, b'0', 'مدرب ووشوكنغ فو', NULL, '2019-10-07 12:13:50'),
(802, 3, 'Sherif Saad Elghrib', '201111442565', NULL, 'sherifsaad3000@gmail.com', NULL, 'القاهرة', 'شباب فى حب مصر', NULL, NULL, NULL, 60, b'0', 'مدير', NULL, '2019-10-07 12:13:50'),
(803, 3, 'عادل خليل عيد سليمان', '201237199047', NULL, 'adl_khalil@yahoo.com', NULL, 'القاهرة', 'المتحدث الرسمي والمنسق والمدير العام لشركه', NULL, NULL, NULL, 61, b'0', 'فني براده', NULL, '2019-10-07 12:13:50'),
(804, 3, 'Hassan Khalaf', '201068318545', NULL, 'hassankhalaf78@yahoo.com', NULL, 'القاهرة', 'Chef', NULL, NULL, NULL, 62, b'1', 'مهندس معماري بجهاز مدينة أسيوط الجديدة بالدرجة الأولى التخصصية', NULL, '2019-10-07 12:13:50'),
(805, 3, 'Lolo Katy', '1226910908', NULL, 'lolo_katy@yahoo.com', NULL, 'القاهرة', 'اخصاءي تسويق', NULL, NULL, NULL, 63, b'0', 'معلم', NULL, '2019-10-07 12:13:50'),
(806, 3, 'حسام محمد عنتر', '201110241033', NULL, 'h.elraa@yahoo.com', NULL, 'الجيزة', 'Engineer', NULL, NULL, NULL, 64, b'0', 'مساعدمدير', NULL, '2019-10-07 12:13:50'),
(807, 3, 'Nady Antr Adm', '201232357300', NULL, 'hhss.nady@gmail.com', NULL, 'الجيزة', 'Accountant', NULL, NULL, NULL, 65, b'0', 'سواق جامبو', NULL, '2019-10-07 12:13:50'),
(808, 3, 'Amr Abdelazem Kholief', '201270259995', NULL, 'kholief_amr@yahoo.com', NULL, 'القاهرة', 'ماجستير تربة', NULL, NULL, NULL, 66, b'0', 'Amr Kholief', NULL, '2019-10-07 12:13:50'),
(809, 3, 'Mohamed Elrwdy', '1228535352', NULL, 'elrwdy3@yahoo.com', NULL, 'القاهرة', 'معلم', NULL, NULL, NULL, 25, b'0', 'صاحب مكتب استيراد وتصدير', NULL, '2019-10-07 12:13:50'),
(810, 3, 'ابو ياسين', '201115740157', NULL, 'sr_love11@yahoo.com', NULL, 'الإسكندرية', 'دبلوم هندسه', NULL, NULL, NULL, 26, b'0', 'تبريد وتكيف', NULL, '2019-10-07 12:13:50'),
(811, 3, 'هانى ابودراهم المعازي', '201002161579', NULL, 'hanidrahim@yahoo.com', NULL, 'القاهرة', 'مندوب بيع', NULL, NULL, NULL, 27, b'0', 'مندوب', NULL, '2019-10-07 12:13:50'),
(812, 3, 'محمد يحيى', '201225785343', NULL, 'mohmed.yhya1@gmail.com', NULL, 'القاهرة', 'مندوب مبيعات', NULL, NULL, NULL, 28, b'0', 'معلم', NULL, '2019-10-07 12:13:50'),
(813, 3, 'احمد عبد المقصود احمد', '1223906178', NULL, 'aelbasha177@yahoo.com', NULL, 'الدقهلية', 'Business executive', NULL, NULL, NULL, 29, b'0', 'رجل اعمال', NULL, '2019-10-07 12:13:50'),
(814, 3, 'احمد دياب', '201062561145', NULL, 'ga_sun21@yahoo.com', NULL, 'القاهرة', 'محاسب', NULL, NULL, NULL, 30, b'1', 'الاسلام ديني', NULL, '2019-10-07 12:13:50'),
(815, 3, 'احمد عادلي', '201111917383', NULL, 'ahmedadely10@yahoo.com', NULL, 'القاهرة', 'Teacher', NULL, NULL, NULL, 31, b'0', 'معهد جوته القاهره', NULL, '2019-10-07 12:13:50'),
(816, 3, 'Hamada Hamada Gh', '201008612792', NULL, 'hamadagh75@gmail.com', NULL, 'القاهرة', 'civil engineer', NULL, NULL, NULL, 32, b'0', 'محامي', NULL, '2019-10-07 12:13:50'),
(817, 3, 'Aeng Ahmed', '201066618488', NULL, 'ahmedibrahim46@gmail.com', NULL, 'القاهرة', 'مهندس', NULL, NULL, NULL, 33, b'0', 'مهندس تصميمات', NULL, '2019-10-07 12:13:50'),
(818, 3, 'Anwer Hesham', '201153886326', NULL, 'anwarkzalek@yahoo.com', NULL, 'القاهرة', 'طالب', NULL, NULL, NULL, 34, b'0', 'طالب بكلية تجارة', NULL, '2019-10-07 12:13:50'),
(819, 3, 'Mahmoud  Massoud Aboelsaad', '201069980662', NULL, 'maboelsaad@gmail.com', NULL, 'القاهرة', 'Teacher', NULL, NULL, NULL, 35, b'0', 'رئيس قسم كيمياء وتقنية المبيدات-كلية الزراعة جامعة الأسكندرية', NULL, '2019-10-07 12:13:50'),
(820, 3, 'Mohamed Hossam Alamrkany', '201207398441', NULL, 'tigerdragin1210@gmail.com', NULL, 'القاهرة', 'Cda', NULL, NULL, NULL, 36, b'0', 'محامي', NULL, '2019-10-07 12:13:50'),
(821, 3, 'Ali suliman', '201275072260', NULL, 'alysuliman0@gmail.com', NULL, 'القليوبية', 'اخصائي اول بصريات', NULL, NULL, NULL, 37, b'0', 'Animation', NULL, '2019-10-07 12:13:50'),
(822, 3, 'Ahmed Attalla', '201000493757', NULL, 'ahmedattalla8888@yahoo.com', NULL, 'القاهرة', 'عمل خاص', NULL, NULL, NULL, 38, b'0', 'طالب', NULL, '2019-10-07 12:13:50'),
(823, 3, 'Μõhãmêđ Ašhräf', '201024328142', NULL, 'misho_love_love201314@yahoo.com', NULL, 'القاهرة', 'اداره اعمال', NULL, NULL, NULL, 39, b'0', 'مدير اول حكام', NULL, '2019-10-07 12:13:50'),
(824, 3, 'حسين امير محمد صلاح الدين', '201236327178', NULL, 'h.hssen40@yahoo.com', NULL, 'القاهرة', 'Engineer', NULL, NULL, NULL, 40, b'1', 'حاصل على معهد سياحه وفنادق', NULL, '2019-10-07 12:13:50'),
(825, 3, 'Tony Nagy', '201234048078', NULL, 'tonynagy2020@yahoo.com', NULL, 'الدقهلية', 'manjer', NULL, NULL, NULL, 41, b'0', 'محاسب', NULL, '2019-10-07 12:13:50'),
(826, 3, 'انا حبيبة بابتي انا', '201222347745', NULL, 'myasmen354@gmail.com', NULL, 'القاهرة', 'محاسبه', NULL, NULL, NULL, 42, b'0', 'معرض تحف', NULL, '2019-10-07 12:13:50'),
(827, 3, 'Abd EL-Rahman Okasha', '201112170761', NULL, 'hamenyokasha@yahoo.com', NULL, 'القاهرة', 'Business Man', NULL, NULL, NULL, 43, b'0', 'رجل اعمال', NULL, '2019-10-07 12:13:50'),
(828, 3, 'mohamed amr salah', '201023178014', NULL, 'devil_1500_50@hotmail.com', NULL, 'القاهرة', 'مديرمبيعات', NULL, NULL, NULL, 44, b'0', 'hamada', NULL, '2019-10-07 12:13:50'),
(829, 3, 'Sayed Ashraf', '201147680292', NULL, 'shref.wener@yahoo.com', NULL, 'الجيزة', 'mahdi', NULL, NULL, NULL, 45, b'0', 'travel advisor', NULL, '2019-10-07 12:13:50'),
(830, 3, 'Ahmed Amir', '201155233488', NULL, 'ahmedamier88@gmail.com', NULL, 'القاهرة', 'مدير موقع مستشفى', NULL, NULL, NULL, 46, b'0', 'accountant', NULL, '2019-10-07 12:13:50'),
(831, 3, 'Marawan Elmarasy', '201016300400', NULL, 'marawan-elmarasy@yahoo.com', NULL, 'القاهرة', 'مساعد مدير إدارة العمليات المحليه', NULL, NULL, NULL, 47, b'0', 'Front Office manager', NULL, '2019-10-07 12:13:50'),
(832, 3, 'Fahd Ahmed Alrian', '96555253055', NULL, 'fahdalrian1@gmail.com', NULL, 'القاهرة', 'ﻻ أعمل', NULL, NULL, NULL, 48, b'0', 'حاصل ع دبلوم صنايع', NULL, '2019-10-07 12:13:50'),
(833, 3, 'Amel Farouk', '201112509284', NULL, 'amelsasa9@gmail.com', NULL, 'الجيزة', 'إداري', NULL, NULL, NULL, 49, b'0', 'مستشار تحكيم دولى', NULL, '2019-10-07 12:13:50'),
(834, 3, 'Mahmoud Seda', '201000615782', NULL, 'mahmoudseda1@gamil.com', NULL, 'القاهرة', 'إدارة أعمال', NULL, NULL, NULL, 50, b'1', 'لاتوجد وظيفه', NULL, '2019-10-07 12:13:50'),
(835, 3, 'Mahmoud Fayed', '201116295196', NULL, 'fayed103@gmail.com', NULL, 'القاهرة', 'مساعد امين مستودع', NULL, NULL, NULL, 51, b'0', 'IT Technician', NULL, '2019-10-07 12:13:50'),
(836, 3, 'محمد عبد المعبود', '201092289241', NULL, 'apdo_ma@yahoo.com', NULL, 'الجيزة', 'تجارة عامة', NULL, NULL, NULL, 52, b'0', 'عاطل', NULL, '2019-10-07 12:13:50'),
(837, 3, 'محمد احمد منصور', '201012146763', NULL, 'bassbass108@gmail.com', NULL, 'القاهرة', 'حداد', NULL, NULL, NULL, 53, b'0', 'ترزى', NULL, '2019-10-07 12:13:50'),
(838, 3, 'Yasmine Elzwawy', '201000527257', NULL, 'yasmineelzawawy@yahoo.com', NULL, 'القاهرة', 'مدقق', NULL, NULL, NULL, 54, b'0', 'مدرسه', NULL, '2019-10-07 12:13:50'),
(839, 3, 'Mido W Mido', '1140044575', NULL, 'medo_hamada20000@yahoo.com', NULL, 'القاهرة', 'translation', NULL, NULL, NULL, 55, b'0', 'محاسب', NULL, '2019-10-07 12:13:50'),
(840, 3, 'وثقت بربى فلن يخذلنى', '201236036482', NULL, 'mego2512015@yahoo.com', NULL, 'القاهرة', 'مهندس كمبيوتر', NULL, NULL, NULL, 56, b'0', 'قارئة', NULL, '2019-10-07 12:13:50'),
(841, 3, 'مؤمن محسن عبدالغنى', '201026282416', NULL, 'moamn.elol@yahoo.com', NULL, 'القاهرة', 'دراسة اعمال', NULL, NULL, NULL, 57, b'0', 'حاصل على دبلوم', NULL, '2019-10-07 12:13:50'),
(842, 3, 'ابانوب نبيل', '201224884968', NULL, 'benonabil84@gmail.com', NULL, 'القاهرة', 'صراف', NULL, NULL, NULL, 58, b'0', 'Special Education Specialist', NULL, '2019-10-07 12:13:50'),
(843, 3, 'Khaled Noby', '1120544248', NULL, 'khalednoby885@yahoo.com', NULL, 'القاهرة', 'موطف في الحومه', NULL, NULL, NULL, 59, b'0', 'محامى', NULL, '2019-10-07 12:13:50'),
(844, 3, 'احمد يوسف', '201066325398', NULL, 'ahmeduosef_2010@yahoo.com', NULL, 'القاهرة', 'Graduater senior student', NULL, NULL, NULL, 60, b'1', 'دعم فني دش', NULL, '2019-10-07 12:13:50'),
(845, 3, 'احمد الامير المحامى', '201223534336', NULL, 'timoor2010_ahmed@yahoo.com', NULL, 'الجيزة', 'مدير اقليمي', NULL, NULL, NULL, 61, b'0', 'محامي', NULL, '2019-10-07 12:13:50'),
(846, 3, 'Samer Soliman', '201002050058', NULL, 'eltomygroup@icloud.com', NULL, 'القاهرة', 'bacalorios health adminstration', NULL, NULL, NULL, 62, b'0', 'Manager', NULL, '2019-10-07 12:13:50'),
(847, 3, 'عمرو محمد جابر سليمان', '1011994302', NULL, 'a.mr20023@yahoo.com', NULL, 'القاهرة', 'مسؤله قسم', NULL, NULL, NULL, 63, b'0', 'مهندس حاسب آلي', NULL, '2019-10-07 12:13:50'),
(848, 3, 'John Mohsen', '201001783059', NULL, 'jojo_dj45@yahoo.com', NULL, 'القاهرة', 'ممرضه', NULL, NULL, NULL, 64, b'0', 'مهندس كمبيوتر', NULL, '2019-10-07 12:13:50'),
(849, 3, 'ريتاج جعفر', '968982326122', NULL, 'memegafar2@gmail.com', NULL, 'القاهرة', 'اداره اعمال', NULL, NULL, NULL, 65, b'0', 'لا شيء', NULL, '2019-10-07 12:13:50'),
(850, 3, 'Mohamed Elgamel', '213944494193', NULL, 'kapoooo99@gmail.com', NULL, 'الجيزة', 'طالب', NULL, NULL, NULL, 66, b'0', 'صحفي', NULL, '2019-10-07 12:13:50'),
(851, 3, 'ايمي ابراهيم احمد', '1063121485', NULL, 'moany-20013@yahoo.com', NULL, 'القاهرة', 'Software Engineer', NULL, NULL, NULL, 25, b'0', 'فنانه', NULL, '2019-10-07 12:13:50'),
(852, 3, 'Ahmed Elhelali', '1069662056', NULL, 'mido_miro710@yahoo.com', NULL, 'القاهرة', 'كلية فنون جميلة', NULL, NULL, NULL, 26, b'0', '!!', NULL, '2019-10-07 12:13:50'),
(853, 3, 'Ataa Araby', '201229173464', NULL, 'rouqa_rouqia@yahoo.com', NULL, 'القاهرة', 'مهند', NULL, NULL, NULL, 27, b'0', 'كاتبه وحاصله على معهد فنى تجاري بتقدير يد جدا', NULL, '2019-10-07 12:13:50'),
(854, 3, 'Eslam Osman', '01114355330', '', 'abdob2623@gmail.com', '', 'الدقهلية', 'office Secretary', '', '', 'النزهه الجديدة', 28, b'0', 'English teacher', NULL, '2019-10-07 12:13:50'),
(855, 3, 'يسرى عرابى', '201115625251', NULL, 'yuossrioraby@gmail.com', NULL, 'القاهرة', 'كتور صيدلئ', NULL, NULL, NULL, 29, b'0', 'محاسب', NULL, '2019-10-07 12:13:50'),
(856, 3, 'Ahmed Gabr', '201090952917', NULL, 'ahmedgabr1212@yahoo.com', NULL, 'القاهرة', 'pharmacist', NULL, NULL, NULL, 30, b'0', 'احمد جمعه', NULL, '2019-10-07 12:13:50'),
(857, 3, 'أحمد عبده', '201019511591', NULL, 'ahmed.642010@yahoo.com', NULL, 'القاهرة', 'دبلوم عالي محاسبه', NULL, NULL, NULL, 31, b'0', 'طالب', NULL, '2019-10-07 12:13:50'),
(858, 3, 'Dr-yahia Shalaby', '1122229120', NULL, 'Dr.yahiashalaby@yahoo.com', NULL, 'القاهرة', 'Studying engineer', NULL, NULL, NULL, 32, b'0', 'District Manager', NULL, '2019-10-07 12:13:50'),
(859, 3, 'Ahmed Mahmoud', '201270057668', NULL, 'ka3bool50@yahoo.com', NULL, 'القاهرة', 'مستشار قانوني واداري', NULL, NULL, NULL, 33, b'0', 'مستشار', NULL, '2019-10-07 12:13:50'),
(860, 3, 'Ana Nada', '201124839984', NULL, 'nonahelmy55@yahoo.com', NULL, 'الجيزة', 'معلمه', NULL, NULL, NULL, 34, b'0', 'مساعد صيدلي (Pharmacist)', NULL, '2019-10-07 12:13:50'),
(861, 3, 'Essmat Abdel Zaher', '201001812268', NULL, 'essmatmoh@yahoo.com', NULL, 'القاهرة', 'Central Risk Manager', NULL, NULL, NULL, 35, b'0', 'استشاري برمجة وقواعد بيانات', NULL, '2019-10-07 12:13:50'),
(862, 3, 'محمد ابراهيم عسليه', '201095292504', NULL, 'mohamedassalya22@yahoo.com', NULL, 'القاهرة', 'Owner', NULL, NULL, NULL, 36, b'0', 'طالب جامعى', NULL, '2019-10-07 12:13:50'),
(863, 3, 'Mahmoud A Mahmoud', '201272097757', NULL, 'mesraa513@yahoo.com', NULL, 'القاهرة', 'ادارة الامن', NULL, NULL, NULL, 37, b'0', 'سفير الحب', NULL, '2019-10-07 12:13:50'),
(864, 3, 'Mohamed Samir', '201279475333', NULL, 'elporsaedy@gmail.com', NULL, 'الجيزة', 'اعلامي', NULL, NULL, NULL, 38, b'1', 'محام', NULL, '2019-10-07 12:13:50'),
(865, 3, 'Ayman Ezz Ezz', '201067703238', NULL, 'tamer8008@yahoo.com', NULL, 'القاهرة', 'Financial Manager', NULL, NULL, NULL, 39, b'0', 'مستشار', NULL, '2019-10-07 12:13:50'),
(866, 3, 'Omeil Tharwat', '201237877780', NULL, 'omeilsarwat@yahoo.com', NULL, 'الإسكندرية', 'طبيب بشرى', NULL, NULL, NULL, 40, b'0', 'مدرس رياضيات', NULL, '2019-10-07 12:13:50'),
(867, 3, 'علاء سعيد', '201225609201', NULL, 'salaa3564@gmali.com', NULL, 'القاهرة', 'مصمم', NULL, NULL, NULL, 41, b'0', 'سائق اسعاف', NULL, '2019-10-07 12:13:50'),
(868, 3, 'Mohamed Ezz', '201026622336', NULL, 'zaza_180@yahoo.com', NULL, 'القاهرة', 'Businessperson', NULL, NULL, NULL, 42, b'0', 'مدير إدارة التخليص الجمركى', NULL, '2019-10-07 12:13:50'),
(869, 3, 'العمده ياسر عز مراد', '201007393364', NULL, 'yasser.2141980@jmail.com', NULL, 'الإسكندرية', 'English Teacher', NULL, NULL, NULL, 43, b'0', 'Product Manager', NULL, '2019-10-07 12:13:50'),
(870, 3, 'رضاكمال احمد زيدان', '1003292009', NULL, 'redakamal2011@yahoo.com', NULL, 'القاهرة', 'Civil Engineer', NULL, NULL, NULL, 44, b'0', 'مستشار قانونى بالسعودية', NULL, '2019-10-07 12:13:50'),
(871, 3, 'Radi ahmed hamouda', '201003990025', NULL, 'radiahmed57@gmail.com', NULL, 'الجيزة', 'موظف', NULL, NULL, NULL, 45, b'0', 'حاصل علي دبلوم فني تجاري', NULL, '2019-10-07 12:13:50'),
(872, 3, 'Amir Ebrahem', '201207146183', NULL, 'mero_xp_2013@yahoo.com', NULL, 'القاهرة', 'المدير التنفيذي بمصنع المائدة الاصيلة للصناعات الغذائية', NULL, NULL, NULL, 46, b'0', 'بكاريوس إداره أعمال وحاسب الي', NULL, '2019-10-07 12:13:50'),
(873, 3, 'Wael Arafa', '201000702936', NULL, 'wael_arafa2005@yahoo.com', NULL, 'الجيزة', 'محاسب', NULL, NULL, NULL, 47, b'0', 'اخصاءى صحافة واعلام', NULL, '2019-10-07 12:13:50'),
(874, 3, 'Ahmed Saed', '201119976997', NULL, 'ahmedmemo202@yahoo.com', NULL, 'القاهرة', 'مدير مكتب', NULL, NULL, NULL, 48, b'1', 'Accountant', NULL, '2019-10-07 12:13:50'),
(875, 3, 'أشرف عبدالرحيم أبوزيد القهوجى', '201006913188', NULL, 'abodiaa_73@yahoo.com', NULL, 'القاهرة', 'اقتصاد', NULL, NULL, NULL, 49, b'0', 'بكالوريوس تربيه', NULL, '2019-10-07 12:13:50'),
(876, 3, 'Mayer Mohsen', '201123056253', NULL, 'Mayer.tawadrous@gmail.com', NULL, 'القاهرة', 'مندوب', NULL, NULL, NULL, 50, b'0', 'أستاذ', NULL, '2019-10-07 12:13:50'),
(877, 3, 'Kamel ahmed kamel', '966582672383', NULL, 'kemocut12@gmail.com', NULL, 'القاهرة', 'متخرجه من بكالوريوس اقتصاد', NULL, NULL, NULL, 51, b'0', 'سائق', NULL, '2019-10-07 12:13:50'),
(878, 3, 'سعيد محمود', '201097508020', NULL, 'mahm0udsaad2015@gmail.com', NULL, 'الجيزة', 'engineer', NULL, NULL, NULL, 52, b'0', 'محاسب قانونى في شركة الكهرباء', NULL, '2019-10-07 12:13:50'),
(879, 3, 'احمد محمد السيد مرواد', '1202088499', NULL, 'romio200820002002@yahoo.com', NULL, 'الدقهلية', 'نائب مدير ادارة', NULL, NULL, NULL, 53, b'0', 'حاصل علي بكالويس تجاره', NULL, '2019-10-07 12:13:50'),
(880, 3, 'Mohamed Mohsen', '201154372517', NULL, 'mohamed_medo01@yahoo.com', NULL, 'الدقهلية', 'معاون مدير حسابات', NULL, NULL, NULL, 54, b'0', 'اعلامي', NULL, '2019-10-07 12:13:50'),
(881, 3, 'ممدوح رجاءى رضوان محمدالسعودى', '201005137061', NULL, 'mamdouhragaey3@gmail.com', NULL, 'الإسكندرية', 'hr', NULL, NULL, NULL, 55, b'0', 'محامي نقض', NULL, '2019-10-07 12:13:50'),
(882, 3, 'Beshoy Nagy', '1207076401', NULL, 'vetox200@gmail.com', NULL, 'القاهرة', 'موظف إدارى بوزراه التربيه والتعليم', NULL, NULL, NULL, 56, b'0', 'طالب كليه حقوق', NULL, '2019-10-07 12:13:50'),
(883, 3, 'Mohamed Turki', '201222784792', NULL, 'mohamed_turki3@yahoo.com', NULL, 'القاهرة', 'مشرف مبيعات', NULL, NULL, NULL, 57, b'0', 'موجه بالتربيه والتعليم', NULL, '2019-10-07 12:13:50'),
(884, 3, 'ماجد عتمان', '201098537171', NULL, 'faresfahd99@yahoo.com', NULL, 'الجيزة', 'ال', NULL, NULL, NULL, 58, b'1', 'مزرعة دواجن', NULL, '2019-10-07 12:13:50'),
(885, 3, 'Ahmed Mohamed elhofy', '201155520546', NULL, 'elshafra_3@yahoo.com', NULL, 'الجيزة', 'حسابات', NULL, NULL, NULL, 59, b'0', 'مستشار تحكيم دولي', NULL, '2019-10-07 12:13:50'),
(886, 3, 'Mohamed Elhady', '201063600342', NULL, 'melhade54@yahoo.com', NULL, 'القاهرة', 'م.مديرمخازن', NULL, NULL, NULL, 60, b'0', 'مستخلص', NULL, '2019-10-07 12:13:50'),
(887, 3, 'Mahmoud Sharawy', '201123418172', NULL, 'sharawy3030@yahoo.com', NULL, 'القاهرة', 'تجارة حرة', NULL, NULL, NULL, 61, b'0', 'باحث اجتماعي', NULL, '2019-10-07 12:13:50'),
(888, 3, 'Adel Mohamed', '201091076163', NULL, 'm_mohamed5555522@yahoo.com', NULL, 'القاهرة', 'district manager', NULL, NULL, NULL, 62, b'0', 'محاسب', NULL, '2019-10-07 12:13:50'),
(889, 3, 'صالح الكاشف', '201004045508', NULL, 'aaboahmed21@gmail.com', NULL, 'الجيزة', 'مشرف اطقم ضييافة جوية دبلوم عالي ادارؤ اعمال', NULL, NULL, NULL, 63, b'0', 'موظف', NULL, '2019-10-07 12:13:50'),
(890, 3, 'Karim Eldeep', '1201744047', NULL, 'karimeldeep84@yahoo.com', NULL, 'القاهرة', 'موظف إدارى', NULL, NULL, NULL, 64, b'0', 'ملازم (رتبة عسكرية)', NULL, '2019-10-07 12:13:50'),
(891, 3, 'نبيل أحمد سلامة على', '201222561048', NULL, 'abogabal8@gmail.com', NULL, 'القاهرة', 'مدرس احياء', NULL, NULL, NULL, 65, b'0', 'أخصائ شباب ومشرف عام أنشطة', NULL, '2019-10-07 12:13:50'),
(892, 3, 'mahmoud mohamed metwally', '1208050682', NULL, 'mago.mago18@yahoo.com', NULL, 'القاهرة', 'مختبرات طيية', NULL, NULL, NULL, 66, b'0', 'مستشار تحكيم دولي', NULL, '2019-10-07 12:13:50'),
(893, 3, 'محمود المصرى', '201063008355', NULL, 'hoda_m202014@yahoo.com', NULL, 'الدقهلية', 'طالبه', NULL, NULL, NULL, 25, b'0', 'لحام', NULL, '2019-10-07 12:13:50'),
(894, 3, 'كيمو راضى', '201220453959', NULL, 'kimo200682@yahoo.com', NULL, 'الجيزة', 'لبنان', NULL, NULL, NULL, 26, b'1', 'موهندس ديكور', NULL, '2019-10-07 12:13:50'),
(895, 3, 'Abdo Alraig', '201114842387', NULL, 'mwo16@yahoo.com', NULL, 'القاهرة', 'مدير. شركه أصلان وشركاه للاسكان والاستثمار', NULL, NULL, NULL, 27, b'0', 'طالب جامعي', NULL, '2019-10-07 12:13:50'),
(896, 3, 'طارق لطفي', '201225875722', NULL, 'tareklotfy142@Yahoo.com', NULL, 'القاهرة', 'طالب', NULL, NULL, NULL, 28, b'0', 'حاصل على دبلوم تجارة 2006', NULL, '2019-10-07 12:13:50'),
(897, 3, 'Ahmed Hussien', '1017208555', NULL, 'ahmedhassun444@gmail.com', NULL, 'الجيزة', 'مبرمج', NULL, NULL, NULL, 29, b'0', 'مهندس ديكور', NULL, '2019-10-07 12:13:50'),
(898, 3, 'جبار الاسدي', '9647702650756', NULL, 'jabar_zain@yahoo.com', NULL, 'القاهرة', 'عمل حر', NULL, NULL, NULL, 30, b'0', 'موظف حكومي', NULL, '2019-10-07 12:13:50'),
(899, 3, 'وائل محمد فتحي حبيش', '201224469039', NULL, 'waelbishoo7@gmail.com', NULL, 'القاهرة', 'Shelter Project Manager - South', NULL, NULL, NULL, 31, b'0', 'مدير عام', NULL, '2019-10-07 12:13:50'),
(900, 3, 'احمد الشبح', '1008021688', NULL, 'aa698667@gmail.com', NULL, 'الجيزة', 'طالب', NULL, NULL, NULL, 32, b'0', 'الزيتوان', NULL, '2019-10-07 12:13:50'),
(901, 3, 'Saed Nsr', '201009055788', NULL, 'saed.pop356@gmail.com', NULL, 'الجيزة', 'hr', NULL, NULL, NULL, 33, b'0', 'طالب', NULL, '2019-10-07 12:13:50'),
(902, 3, 'Samy Teleb', '1111441571', NULL, 'samyteleb570@yahoo.com', NULL, 'الجيزة', 'دبلوماسي', NULL, NULL, NULL, 34, b'0', 'معلم ا', NULL, '2019-10-07 12:13:50'),
(903, 3, 'صبري محمد مصطفى عطيه', '201225427300', NULL, 'sabrysoliman@yahoo.com', NULL, 'مدينة 6 أكتوبر', 'doctor', NULL, NULL, NULL, 35, b'0', 'مدير مالي واداري', NULL, '2019-10-07 12:13:50'),
(904, 3, 'Mostafa Ahmed', '201115112282', NULL, 'momr417@gmail.com', NULL, 'الجيزة', 'Secretaria', NULL, NULL, NULL, 36, b'1', 'مبيعات', NULL, '2019-10-07 12:13:50'),
(905, 3, 'Ahmed Mahmoued', '201025285856', NULL, 'ahmedtitio2020@yahoo.com', NULL, 'الإسكندرية', 'Hello', NULL, NULL, NULL, 37, b'0', 'محاسب', NULL, '2019-10-07 12:13:50'),
(906, 3, 'Môĥâmeď Hāgāģ', '201020069893', NULL, 'mohamedhagagg11@yahoo.com', NULL, 'الجيزة', 'شركة تصدير واستيراد', NULL, NULL, NULL, 38, b'0', 'حر نفسي', NULL, '2019-10-07 12:13:50'),
(907, 3, 'وائل اسماعيل', '201000751956', NULL, 't.2090@yahoo.com', NULL, 'القاهرة', 'radiology', NULL, NULL, NULL, 39, b'0', 'موظف', NULL, '2019-10-07 12:13:50'),
(908, 3, 'Ahmed El Sawy', '201027277971', NULL, 'hamadaelsawy99@yahoo.com', NULL, 'القاهرة', 'Vice President', NULL, NULL, NULL, 40, b'0', 'مشرف موقع', NULL, '2019-10-07 12:13:50'),
(909, 3, 'DrAhmed Maher', '1228971832', NULL, 'maher_a69@yahoo.com', NULL, 'الإسكندرية', 'موظف', NULL, NULL, NULL, 41, b'0', 'بروفيسور', NULL, '2019-10-07 12:13:50'),
(910, 3, 'عمر خالد', '201119419830', NULL, 'adballah33381@gmail.com', NULL, 'بورسعيد', 'ربة بيت', NULL, NULL, NULL, 42, b'0', 'دبلاوم صنايع', NULL, '2019-10-07 12:13:50'),
(911, 3, 'مجدى ثابت فهمي حبشي', '1227136492', NULL, 'magdyhapashy@gmail.com', NULL, 'القاهرة', 'Educational Psychologist', NULL, NULL, NULL, 43, b'0', 'صاحب مشغل لصناعة الملابس', NULL, '2019-10-07 12:13:50');
INSERT INTO `customercrm` (`customerCrmId`, `addedby`, `customerCrmName`, `customerCrmPhone`, `customerCrmSecondPhone`, `customerCrmEmail`, `customerCrmCompany`, `customerCrmGov`, `customerCrmJob`, `customerCrmQualification`, `customerCrmCountry`, `customerCrmAddress`, `customerCrmAge`, `customerCrmGender`, `customerCrmActivity`, `customerCrmOther`, `customerCrmCreateDate`) VALUES
(912, 3, 'Eslam Eladawy', '201112332045', NULL, 'almarede@yahoo.com', NULL, 'الإسكندرية', 'teatcher', NULL, NULL, NULL, 44, b'0', 'مستشار', NULL, '2019-10-07 12:13:50'),
(913, 3, 'امين طاهر نبهان', '201009016464', NULL, 'amin_norin_2@yahoo.com', NULL, 'القاهرة', 'مدرس', NULL, NULL, NULL, 45, b'0', 'اخصائي اجتماعي', NULL, '2019-10-07 12:13:50'),
(914, 3, 'حلم العمر', '201229960220', NULL, 'abohnyn@yaho.com', NULL, 'القاهرة', 'مهندس.معدات طبيه', NULL, NULL, NULL, 46, b'1', 'كهرباء', NULL, '2019-10-07 12:13:50'),
(915, 3, 'أسماء القيصر', '201152143722', NULL, 'asmaa.elshamy01116@gmail.com', NULL, 'القاهرة', 'اداره اعمال', NULL, NULL, NULL, 47, b'0', 'طالبة', NULL, '2019-10-07 12:13:50'),
(916, 3, 'محمود جيدو', '201270866076', NULL, 'ss_ww106@yahoo.com', NULL, 'القاهرة', 'Doctor', NULL, NULL, NULL, 48, b'0', 'نظم ومعلومات', NULL, '2019-10-07 12:13:50'),
(917, 3, 'Hussein Teka', '201007363153', NULL, 'hussein_teka@yahoo.com', NULL, 'الجيزة', 'محلسب', NULL, NULL, NULL, 49, b'0', 'امين مخزن', NULL, '2019-10-07 12:13:50'),
(918, 3, 'Leto Alex', '201202182624', NULL, 'dragoon_2009@yahoo.com', NULL, 'القاهرة', 'مدير مشروعات', NULL, NULL, NULL, 50, b'0', 'فني كنتروول', NULL, '2019-10-07 12:13:50'),
(919, 3, 'Abduallah Gafar', '201126990220', NULL, 'beibo_13@hotmail.com', NULL, 'الغربية', 'مبرمج', NULL, NULL, NULL, 51, b'0', 'Sales Executive', NULL, '2019-10-07 12:13:50'),
(920, 3, 'محمد عبدالمتعال محمود محمد عبدالله', '201235500370', NULL, 'amoor.yosif@gmail.com', NULL, 'القاهرة', 'بكالوريوس اداب', NULL, NULL, NULL, 52, b'0', 'مقاول أعمال كهرباء', NULL, '2019-10-07 12:13:50'),
(921, 3, 'احمد الليثى', '201100904446', NULL, 'shehab.soha@yahoo.com', NULL, 'القاهرة', 'معلمة قرآن', NULL, NULL, NULL, 53, b'0', 'اخصاءى موارد بشرية', NULL, '2019-10-07 12:13:50'),
(922, 3, 'Mohamed Ali Ram', '201098804620', NULL, 'medo000777@yahoo.com', NULL, 'الجيزة', 'كلية طب الأسنان', NULL, NULL, NULL, 54, b'0', 'مهندس', NULL, '2019-10-07 12:13:50'),
(923, 3, 'على السيد مجاهد', '201222946000', NULL, 'prof_megahed@yahoo.com', NULL, 'الجيزة', 'Security Engineer', NULL, NULL, NULL, 55, b'0', 'رئيس حسابات', NULL, '2019-10-07 12:13:50'),
(924, 3, 'Mostafa Ezzat abdel slam Ahmad', '201012447821', NULL, 'kranshymostafa@gmail.com', NULL, 'القاهرة', 'موظف في تربية قضاء دهوك', NULL, NULL, NULL, 56, b'1', 'نائب رئيس اتحاد طلبه كليه الخدمه الاجتماعيه جامعه حلوان', NULL, '2019-10-07 12:13:50'),
(925, 3, 'Hassan Ghazy', '201227038765', NULL, 'hassanghazy78@gmail.com', NULL, 'الجيزة', 'مدير مخازن', NULL, NULL, NULL, 57, b'0', 'محاسب اول بوزارة التربيه والتعليم', NULL, '2019-10-07 12:13:50'),
(926, 3, 'Mohammed Barakat', '201010200242', NULL, 'mohamed.adel.barakat.87@gmail.com', NULL, 'القاهرة', 'مدير مالي', NULL, NULL, NULL, 58, b'0', 'صاحب شركه كابى', NULL, '2019-10-07 12:13:50'),
(927, 3, 'Reem Waheed', '201147414209', NULL, 'ronahazim1996@yahoo.com', NULL, 'القاهرة', 'customer  service', NULL, NULL, NULL, 59, b'0', 'reem waheed', NULL, '2019-10-07 12:13:50'),
(928, 3, 'Ahmed Rami', '201200902908', NULL, 'ramimagk@yahoo.com', NULL, 'الجيزة', 'رئيس المنظمة', NULL, NULL, NULL, 60, b'0', 'Dancer', NULL, '2019-10-07 12:13:50'),
(929, 3, 'Sayed Salem', '201220419601', NULL, 'sayedsalem34@yahoo.com', NULL, 'الإسكندرية', 'planning Engineer', NULL, NULL, NULL, 61, b'0', 'لا يوجد', NULL, '2019-10-07 12:13:50'),
(930, 3, 'Ehaab Abdala aly', '201001520131', NULL, 'ehaaab5@yahoo.com', NULL, 'القاهرة', 'Architect', NULL, NULL, NULL, 62, b'0', 'صاحب مكتب استيراد وتصدير', NULL, '2019-10-07 12:13:50'),
(931, 3, 'Jana Mohmed', '1093388192', NULL, 'l2mis_2011@hotmail.com', NULL, 'القاهرة', 'امين صندوق', NULL, NULL, NULL, 63, b'0', 'أخصائي نفسي', NULL, '2019-10-07 12:13:50'),
(932, 3, 'خميس محمد حسن مصطفى', '201270781547', NULL, 'maryam7781@yahoo.com', NULL, 'مدينة 6 أكتوبر', 'مهندس مدني', NULL, NULL, NULL, 64, b'0', 'خميس محمد حسن مصطفى', NULL, '2019-10-07 12:13:50'),
(933, 3, 'Shabanshmed Rdyin', '201015544959', NULL, 'errr5781@mail.com', NULL, 'القاهرة', 'عمل حر. تجارة', NULL, NULL, NULL, 65, b'0', 'بدون عمل', NULL, '2019-10-07 12:13:50'),
(934, 3, 'نسمه وكلمه', '201091208515', NULL, 'sanaaahmed594@yahoo.com', NULL, 'القاهرة', 'Storekeper', NULL, NULL, NULL, 66, b'1', 'معادن زخروفيه وصياغه', NULL, '2019-10-07 12:13:50'),
(935, 3, 'كريم احمد علي اسماعيل', '201148027304', NULL, 'karemfox19@yahoo.com', NULL, 'الجيزة', 'طالب', NULL, NULL, NULL, 25, b'0', 'لاعب كرة قدم', NULL, '2019-10-07 12:13:50'),
(936, 3, 'ﻣﻮﺳﻲ ﺍﻟﻔﻘﻲ', '201118262863', NULL, 'mmossuaposs@gamil.com', NULL, 'الإسكندرية', 'Goverment Job', NULL, NULL, NULL, 26, b'0', 'أعمال حرة', NULL, '2019-10-07 12:13:50'),
(937, 3, 'Waled Pop', '1152334410', NULL, 'waledpoppopwaled@yahoo.com', NULL, 'الجيزة', 'GM', NULL, NULL, NULL, 27, b'0', 'موطف بالدوله', NULL, '2019-10-07 12:13:50'),
(938, 3, 'Badr Mazeka', '201153811041', NULL, 'mm5032@yahoo.com', NULL, 'القاهرة', 'student universtaye', NULL, NULL, NULL, 28, b'0', 'فني فونيس سيارت', NULL, '2019-10-07 12:13:50'),
(939, 3, 'محمد فتحى أحمد', '201224518624', NULL, 'mmfat7e@yahoo.com', NULL, 'الدقهلية', 'مدير عام', NULL, NULL, NULL, 29, b'0', 'مسؤول مبيعات', NULL, '2019-10-07 12:13:50'),
(940, 3, 'عبدالله البدري احمد', '201112844577', NULL, 'a01112344577@yahoo.com', NULL, 'القاهرة', 'ربة منزل', NULL, NULL, NULL, 30, b'0', 'دمياط رأس البر', NULL, '2019-10-07 12:13:50'),
(941, 3, 'الشيخ مصطفي الغرباوي', '201095765857', NULL, 'mostafa.elgahrbawy@yahoo.com', NULL, 'الجيزة', 'Lecturer', NULL, NULL, NULL, 31, b'0', 'قارئ القرآن الكريم', NULL, '2019-10-07 12:13:50'),
(942, 3, 'Walid Allam', '201001584928', NULL, 'walid.alaam@hotmail.com', NULL, 'القاهرة', 'مدير مشتريات', NULL, NULL, NULL, 32, b'0', 'Sales manager SEKEM', NULL, '2019-10-07 12:13:50'),
(943, 3, 'Haysam Atef Mahmoud', '201009947845', NULL, 'kind_heart97@yahoo.com', NULL, 'القاهرة', 'agronomist', NULL, NULL, NULL, 33, b'0', 'refrigertor', NULL, '2019-10-07 12:13:50'),
(944, 3, 'Khalf Nhael', '201125902815', NULL, 'khalfnhael@windowslive.com', NULL, 'القاهرة', 'officer', NULL, NULL, NULL, 34, b'1', 'مصور سينمائي', NULL, '2019-10-07 12:13:50'),
(945, 3, 'Mohamed Said Mohamed', '201110359173', NULL, 'm.s2234@yahoo.com', NULL, 'الجيزة', 'مسؤولة موارد بشرية وجودة', NULL, NULL, NULL, 35, b'0', 'عامل', NULL, '2019-10-07 12:13:50'),
(946, 3, 'Taher Omar', '201019231448', NULL, 'melonco-66@hotmail.com', NULL, 'القاهرة', 'English language instructor', NULL, NULL, NULL, 36, b'0', 'مدير عام', NULL, '2019-10-07 12:13:50'),
(947, 3, 'محمد السيد محمد', '201095759904', NULL, 'medo1000_eg@yahoo.com', NULL, 'القاهرة', 'Director of Photography', NULL, NULL, NULL, 37, b'0', 'صيانة محمول', NULL, '2019-10-07 12:13:50'),
(948, 3, 'Gehad Magdy Zeid', '201230700708', NULL, 'gehad_magdy@hotmail.com', NULL, 'الجيزة', 'دراسات', NULL, NULL, NULL, 38, b'0', 'مهندس برمجه', NULL, '2019-10-07 12:13:50'),
(949, 3, 'رومناسى ومنسى', '201144517428', NULL, 'wael8174@gmail.com', NULL, 'القاهرة', 'Marketing Director', NULL, NULL, NULL, 39, b'0', 'يارب', NULL, '2019-10-07 12:13:50'),
(950, 3, 'Moahamed Elmasry', '201126068328', NULL, 'mohamed_elmasry712@yahoo.com', NULL, 'الجيزة', 'Electronic engineer', NULL, NULL, NULL, 40, b'0', 'مدير نفسي', NULL, '2019-10-07 12:13:50'),
(951, 3, 'Sayd Tantawy', '201278880194', NULL, 'saydtantawy769@yahoo.com', NULL, 'الجيزة', 'م.طبي/ صحة مجتمع', NULL, NULL, NULL, 41, b'0', 'فني كهرباء', NULL, '2019-10-07 12:13:50'),
(952, 3, 'حسن ذكى ابو خديجة', '201009573006', NULL, 'hasan.zaky3777@yahoo.com', NULL, 'الجيزة', 'Sales Manager - Medical Imaging Dept', NULL, NULL, NULL, 42, b'0', 'فني الات دقيقة', NULL, '2019-10-07 12:13:50'),
(953, 3, 'Mostafa Ahmed mohmed', '201116135592', NULL, 'mostafa_ahmed199446@yahoo.com', NULL, 'القاهرة', 'مهندس', NULL, NULL, NULL, 43, b'0', 'طالب بكليه حقوق', NULL, '2019-10-07 12:13:50'),
(954, 3, 'احمد جبريل', '201225993525', NULL, 'ahmad.gebrel@yahoo.com', NULL, 'القاهرة', 'مدرس', NULL, NULL, NULL, 44, b'1', 'ﻣﺤﺎﻣﻲ حر', NULL, '2019-10-07 12:13:50'),
(955, 3, 'سهيل حماده محمد', '1200344861', NULL, 'd.sohail_1phnub@yahoo.com', NULL, 'الجيزة', 'اخصائي تنميه اداريه', NULL, NULL, NULL, 45, b'0', 'دكتور صيدلي', NULL, '2019-10-07 12:13:50'),
(956, 3, 'حامد محمد الوكيل', '201091414131', NULL, 'hamedalwekel_y_a@yahoo.com', NULL, 'القاهرة', 'طالب جامعي', NULL, NULL, NULL, 46, b'0', 'سكرتر مدرسه', NULL, '2019-10-07 12:13:50'),
(957, 3, 'Mohamed Mido', '201112881456', NULL, 'mohmedmido884@gmail.com', NULL, 'الغربية', 'Finance Manager', NULL, NULL, NULL, 47, b'0', 'إدارى في شركة مقاولات', NULL, '2019-10-07 12:13:50'),
(958, 3, 'Mohamed Mousa', '201222573930', NULL, 'mo7a002@yahoo.com', NULL, 'القاهرة', 'اقتصاد', NULL, NULL, NULL, 48, b'0', 'استاذ', NULL, '2019-10-07 12:13:50'),
(959, 3, 'Īsraa MōstaFa', '201238162392', NULL, 'stop_love2010@yahoo.com', NULL, 'القاهرة', 'student', NULL, NULL, NULL, 49, b'0', 'Not There Yet :D !', NULL, '2019-10-07 12:13:50'),
(960, 3, 'محمد حسين غنام جمعه', '201068774918', NULL, 'mohamedhassin17@yahoo.com', NULL, 'الإسكندرية', 'Lawyer', NULL, NULL, NULL, 50, b'0', 'حاصل على دبلوم تجاره', NULL, '2019-10-07 12:13:50'),
(961, 3, 'محمد البحيري', '201147778700', NULL, 'medomedoemy82@yahoo.com', NULL, 'القاهرة', 'مدرس فيزياء', NULL, NULL, NULL, 51, b'0', 'مدرس', NULL, '2019-10-07 12:13:50'),
(962, 3, 'Moheamed Ahmed', '201150087003', NULL, 'bosybosy3330@yahoo.com', NULL, 'القاهرة', 'MEP Projects Manager', NULL, NULL, NULL, 52, b'0', 'مومثل مسرح', NULL, '2019-10-07 12:13:50'),
(963, 3, 'د. هشام السعودي', '201005570055', NULL, 'hs6666@hotmail.com', NULL, 'القاهرة', 'Medical technician analyzes', NULL, NULL, NULL, 53, b'0', 'Product Manager دكتور جامعي', NULL, '2019-10-07 12:13:50'),
(964, 3, 'moataz mohamed  mousa', '201201192389', NULL, 'm1995@gmil.com', NULL, 'القاهرة', 'مدير', NULL, NULL, NULL, 54, b'1', 'محاسب دولى', NULL, '2019-10-07 12:13:50'),
(965, 3, 'ايهاب احمد سعد محمد', '201121760674', NULL, 'aboosmma@yahoo.com', NULL, 'القاهرة', 'مﻻح جوي', NULL, NULL, NULL, 55, b'0', 'مراقب جوده', NULL, '2019-10-07 12:13:50'),
(966, 3, 'Ahmed Ayman Shehata', '201002608687', NULL, 'ahmed_ayman1691@yahoo.com', NULL, 'القاهرة', 'مدير اداره', NULL, NULL, NULL, 56, b'0', 'محاسب مالى فى شركة شومان', NULL, '2019-10-07 12:13:50'),
(967, 3, 'Rasha fouad', '1007101212', NULL, 'rosha242@yahoo.com', NULL, 'القاهرة', 'مسؤال ائتمان', NULL, NULL, NULL, 57, b'0', 'accounter', NULL, '2019-10-07 12:13:50'),
(968, 3, 'Raafat Kamel', '201117910299', NULL, 'raafatkameltaher.2011@yahoo.com', NULL, 'القاهرة', 'Admin', NULL, NULL, NULL, 58, b'0', 'دبلوم زراعه', NULL, '2019-10-07 12:13:50'),
(969, 3, 'طارق عزالعرب', '201111673246', NULL, 'tarekezz03@yahoo.com', NULL, 'القاهرة', 'IT', NULL, NULL, NULL, 59, b'0', 'مهنة حره', NULL, '2019-10-07 12:13:50'),
(970, 3, 'محمد فتحي منصور عبدربه', '201009333849', NULL, 'mohamed_fathe53@yahoo.com', NULL, 'القاهرة', 'Doctor physiotherapy', NULL, NULL, NULL, 60, b'0', 'ملاحظ أمن شركه النيل العامة لإنشاء الطرق', NULL, '2019-10-07 12:13:50'),
(971, 3, 'احمد سند', '201122278686', NULL, 'adahmedsanad@yahoo.com', NULL, 'القاهرة', 'Account officer', NULL, NULL, NULL, 61, b'0', 'معلم اول', NULL, '2019-10-07 12:13:50'),
(972, 3, 'Mohmed Ata', '201129960988', NULL, 'atta_mohamed@yahoo.com', NULL, 'القاهرة', 'Financial Accountant', NULL, NULL, NULL, 62, b'0', 'lwer', NULL, '2019-10-07 12:13:50'),
(973, 3, 'Mina Mohsen Soliman', '201274151188', NULL, 'Mena_love_ronah@yahoo.com', NULL, 'الجيزة', 'Architect &amp; project Eingeneer', NULL, NULL, NULL, 63, b'0', 'اخصائي اجتماعي. تنميه بشريه\n\nمهارات الدراسة', NULL, '2019-10-07 12:13:50'),
(974, 3, 'Ahmed Medo Medo', '201020842060', NULL, 'ahmedmedomedo070@gmail.com', NULL, 'القاهرة', 'رجل اعمال', NULL, NULL, NULL, 64, b'1', 'عامل', NULL, '2019-10-07 12:13:50'),
(975, 3, 'Mohamed Jamal', '201060190291', NULL, 'mg343517@gmail.com', NULL, 'القاهرة', 'مندوب', NULL, NULL, NULL, 65, b'0', 'programmer electronic counters', NULL, '2019-10-07 12:13:50'),
(976, 3, 'محمد المرسي', '201066860086', NULL, 'mohamed_elmorsy1983@yahoo.com', NULL, 'القاهرة', 'General Manager', NULL, NULL, NULL, 66, b'0', 'مندوب مبيعات', NULL, '2019-10-07 12:13:50'),
(977, 3, 'محمد الفخرانى', '201225083897', NULL, 'mohmed1982@ymail.com', NULL, 'الجيزة', 'موظف حكومي', NULL, NULL, NULL, 25, b'0', 'صاحب ورشة لتصنيع الموبليا', NULL, '2019-10-07 12:13:50'),
(978, 3, 'Mansour Noufal', '88640143016', NULL, 'aboasmaanoufal@yahoo.com', NULL, 'الإسكندرية', 'woner', NULL, NULL, NULL, 26, b'0', 'محامي ب مصر و الدول العربيه', NULL, '2019-10-07 12:13:50'),
(979, 3, 'محمد مصطفي بخيت', '201091515128', NULL, 'medo33mm@yahoo.com', NULL, 'الجيزة', 'نادل', NULL, NULL, NULL, 27, b'0', 'ليسانس شريعه وقانون', NULL, '2019-10-07 12:13:50'),
(980, 3, 'Mohamed Nasr', '201115200712', NULL, 'Mohamed00000nasr@gmail.com', NULL, 'القاهرة', 'المدیر المفوض لشرکة بوتان للمقاولات العامة المحدودة', NULL, NULL, NULL, 28, b'0', 'مهندس كهرباء', NULL, '2019-10-07 12:13:50'),
(981, 3, 'عصام فتحى', '201222800780', NULL, 'e.elhayat@yahoo.com', NULL, 'بني سويف', 'Human Resources Specialist (HR Specialist)', NULL, NULL, NULL, 29, b'0', 'محامي', NULL, '2019-10-07 12:13:50'),
(982, 3, 'مؤمن فتح الباب محمد كامل', '201002207907', NULL, 'sadpairdmw1@yahoo.com', NULL, 'القاهرة', 'مدير صناعي', NULL, NULL, NULL, 30, b'0', 'حاصل علي بكالريوس خددمه اجتماعيه', NULL, '2019-10-07 12:13:50'),
(983, 3, 'Mahmoud Kassem', '201202803861', NULL, 'hhode10@yahoo.com', NULL, 'القاهرة', 'Treasury Back Office', NULL, NULL, NULL, 31, b'0', 'كلية حقوق جامعه الاسكندريه', NULL, '2019-10-07 12:13:50'),
(984, 3, 'Ali Elbana', '201090845673', NULL, 'eng_ali022@yahoo.com', NULL, 'القاهرة', 'Civil Engineer in Petronas carigali in iraq', NULL, NULL, NULL, 32, b'1', 'مهندس تخطيط', NULL, '2019-10-07 12:13:50'),
(985, 3, 'ابراهيم احمد', '201019703281', NULL, 'goo.oo22@yahoo.com', NULL, 'القاهرة', 'بايلوجي', NULL, NULL, NULL, 33, b'0', 'حاصل علي لسانس حقوق تعليم مفتوح', NULL, '2019-10-07 12:13:50'),
(986, 3, 'خالد مجدي إبراهيم الدواس', '201224325216', NULL, 'khaledeldwss@gmail.com', NULL, 'القاهرة', 'HR', NULL, NULL, NULL, 34, b'0', 'معلم اول أ اخصائي مسرح', NULL, '2019-10-07 12:13:50'),
(987, 3, 'Belal Manchester', '201099984430', NULL, 'belalmanshester@yahoo.com', NULL, 'القاهرة', 'مهندس', NULL, NULL, NULL, 35, b'0', 'نقاش محترف', NULL, '2019-10-07 12:13:50'),
(988, 3, 'ماهر حسين محمود عبد الحافظ محمد العريض', '1079753524', NULL, 'maherhusaen@yahoo.com', NULL, 'القاهرة', 'مراجع ماهيات', NULL, NULL, NULL, 36, b'0', 'اعمال حره صاحب محل', NULL, '2019-10-07 12:13:50'),
(989, 3, 'احمد محمد حسن عبد الحليم', '96566443089', NULL, 'alarbya86@yahoo.com', NULL, 'القاهرة', 'Own Business', NULL, NULL, NULL, 37, b'0', 'حاصل على بكالوريوس نظم معلومات إدارية', NULL, '2019-10-07 12:13:50'),
(990, 3, 'حكايتي انا', '201100393357', NULL, 'zoza.mody18@yahoo.com', NULL, 'الجيزة', 'طالب', NULL, NULL, NULL, 38, b'0', 'زينب محمود محمد', NULL, '2019-10-07 12:13:50'),
(991, 3, 'محمد احمد نور', '1008364597', NULL, 'kemoo_100100@yahoo.com', NULL, 'القاهرة', 'Pa', NULL, NULL, NULL, 39, b'0', 'Videographer', NULL, '2019-10-07 12:13:50'),
(992, 3, 'المشتكي لله', '1200846822', NULL, 'no.love9045@yahoo.com', NULL, 'أسيوط', 'أ مين', NULL, NULL, NULL, 40, b'0', 'امينة علاقات عامة', NULL, '2019-10-07 12:13:50'),
(993, 3, 'Ahmed Fouad Elhawary', '201100074333', NULL, 'hawaritive91@gmail.com', NULL, 'القاهرة', 'جريد المجتمع', NULL, NULL, NULL, 41, b'0', 'مهندس', NULL, '2019-10-07 12:13:50'),
(994, 3, 'نامن مبن', '1232689629', NULL, 'noorbehoo@yahoo.com', NULL, 'القاهرة', 'محاسب', NULL, NULL, NULL, 42, b'1', 'حبوب', NULL, '2019-10-07 12:13:50'),
(995, 3, 'Mähmøûd Ålêx', '201228603999', NULL, 'mhmoud.love93@yahoo.com', NULL, 'القاهرة', 'General Manager', NULL, NULL, NULL, 43, b'0', 'شيف بارستا', NULL, '2019-10-07 12:13:50'),
(996, 3, 'Mohamed Salama', '1020052641', NULL, 'mohamedsalama790@yahoo.com', NULL, 'الجيزة', 'Dentist', NULL, NULL, NULL, 44, b'0', 'مشرف تشغيل', NULL, '2019-10-07 12:13:50'),
(997, 3, 'Abdelrhman Elgebaly', '201122144082', NULL, 'abdo88219@gmail.com', NULL, 'القاهرة', 'Casual free', NULL, NULL, NULL, 45, b'0', 'مهندس مساحه', NULL, '2019-10-07 12:13:50'),
(998, 3, 'Hamadaa Alshaer', '201238138161', NULL, 'hamada_bry@yahoo.com', NULL, 'القاهرة', 'senior supervisor logistics', NULL, NULL, NULL, 46, b'0', 'حسابات', NULL, '2019-10-07 12:13:50'),
(999, 3, 'Ahmed Sanwey', '201006074323', NULL, 'ahmedsanwey@gmail.com', NULL, 'القاهرة', 'مدرس مساعد بقسم التدريب الرياضي وعلم الحركة', NULL, NULL, NULL, 47, b'0', 'شركة بون فيردى للتصدير', NULL, '2019-10-07 12:13:50'),
(1000, 3, 'ßŏŋdŏk Ěł Gŏĥặřŷ', '201227407361', NULL, 'bondokalsadat78@gmail.com', NULL, 'القاهرة', 'Supervisor', NULL, NULL, NULL, 48, b'0', 'لاعب كونغ فو محترف', NULL, '2019-10-07 12:13:50'),
(1001, 3, 'باسم كرم عدلي خليل', '201235746030', NULL, 'basemkarem99@yahoo.com', NULL, 'القاهرة', 'ceo', NULL, NULL, NULL, 49, b'0', 'لا يوجد', NULL, '2019-10-07 12:13:50'),
(1002, 3, 'Adham Donya Reem', '201221871767', NULL, 'hegazya700@yahoo.com', NULL, 'الشرقية', 'إدارية في مدرسه ثانوية', NULL, NULL, NULL, 50, b'0', 'اخصائى أجتماعى', NULL, '2019-10-07 12:13:50'),
(1003, 3, 'شريف على كمال عبد العال الهوارى', '1144115469', NULL, '2mgroup2050@gmail.com', NULL, 'القاهرة', 'libya', NULL, NULL, NULL, 51, b'0', 'مدير شركة ميلانو للخدمات العامة', NULL, '2019-10-07 12:13:50'),
(1004, 3, 'هانى رمضان', '201120129111', NULL, 'hanyramdan10@gmail.com', NULL, 'القاهرة', 'اخصائي تدريس', NULL, NULL, NULL, 52, b'1', 'ضابط امن بشركة كير سيرفيس', NULL, '2019-10-07 12:13:50'),
(1005, 3, 'كريم ماضى', '201275673929', NULL, 'kemoscout@hotmail.com', NULL, 'القاهرة', 'معلمة', NULL, NULL, NULL, 53, b'0', 'موظف بهيئة قناه السويس', NULL, '2019-10-07 12:13:50'),
(1006, 3, 'حسام جاب الله', '201002308158', NULL, 'ziadahmed.hossam@yahoo.com', NULL, 'الجيزة', 'وزارة المالية', NULL, NULL, NULL, 54, b'0', 'فنى بهيئة قناة السويس', NULL, '2019-10-07 12:13:50'),
(1007, 3, 'Ahmed Sopih', '201270907708', NULL, 'sopih_sony@yahoo.com', NULL, 'الجيزة', 'م.صيدلي', NULL, NULL, NULL, 55, b'0', 'فنى الكترونيات', NULL, '2019-10-07 12:13:50'),
(1008, 3, 'Alaa Zakaria', '201207634440', NULL, 'alaazakaria731@yahoo.com', NULL, 'القاهرة', 'Constructin Engineer', NULL, NULL, NULL, 56, b'0', 'ساءق خاص', NULL, '2019-10-07 12:13:50'),
(1009, 3, 'احمد عاشور', '201221420016', NULL, 'anan200200@yahoo.com', NULL, 'القاهرة', 'ادارة اعمال', NULL, NULL, NULL, 57, b'0', 'حاصل على دبلوم صنايع', NULL, '2019-10-07 12:13:50'),
(1010, 3, 'Mohamed EL Almane', '201090933742', NULL, 'mohamedsamy1616@yahoo.com', NULL, 'القاهرة', 'مدير عام جمعية ابداع لتطوير نظم التعليم', NULL, NULL, NULL, 58, b'0', 'سوبر فايزر (كوك دور )مصر الجديدة فرع السفير.', NULL, '2019-10-07 12:13:50'),
(1011, 3, 'Mahmoud Samy A.elhamed', '201002969769', NULL, 'mahmoud_samy_ae@yahoo.com', NULL, 'العاشر من رمضان', 'مهندس', NULL, NULL, NULL, 59, b'0', 'Commerce College', NULL, '2019-10-07 12:13:50'),
(1012, 3, 'Mohamed Aboelward', '201270333399', NULL, 'in.cafe@rocketmail.com', NULL, 'القاهرة', 'اداره اعمال', NULL, NULL, NULL, 60, b'0', 'استيراد وتصدير', NULL, '2019-10-07 12:13:50'),
(1013, 3, 'Mahmoud Ghoneim', '201111294232', NULL, 'mahmoudeljokr293@yahoo.com', NULL, 'القاهرة', 'Teacher English', NULL, NULL, NULL, 61, b'0', 'مدير', NULL, '2019-10-07 12:13:50'),
(1014, 3, 'احمد فايق', '201224572197', NULL, 'elkinga48@ymail.com', NULL, 'القاهرة', 'محاسبه', NULL, NULL, NULL, 62, b'1', 'حاكم دولي', NULL, '2019-10-07 12:13:50'),
(1015, 3, 'محمود ابوالطايف', '201014150018', NULL, 'mahmoudhamam2015@yahoo.com', NULL, 'القاهرة', 'G manager', NULL, NULL, NULL, 63, b'0', 'لا يوجد', NULL, '2019-10-07 12:13:50'),
(1016, 3, 'Mahmoud Haroun', '201012127872', NULL, 'tito_20107589@yahoo.com', NULL, 'القاهرة', 'civil deveince', NULL, NULL, NULL, 64, b'0', 'مندوب توزيع', NULL, '2019-10-07 12:13:50'),
(1017, 3, 'Asmaa Mahmoud mohammed sayd', '201212406579', NULL, 'aamo646@yahoo.com', NULL, 'الجيزة', 'مدير التشغيل', NULL, NULL, NULL, 65, b'0', 'جوده', NULL, '2019-10-07 12:13:50'),
(1018, 3, 'Ahmed Kapo', '1119619696', NULL, 'romancy_lovly10@yahoo.com', NULL, 'الإسكندرية', 'محام ومستشار قانوني', NULL, NULL, NULL, 66, b'0', 'مدير عﻻقات عامه', NULL, '2019-10-07 12:13:50'),
(1019, 3, 'في اختلافنا رحمه', '201222500902', NULL, 'bobo604@yahoo.com', NULL, 'القاهرة', 'Artist', NULL, NULL, NULL, 25, b'0', 'صاحب مهنة حرة', NULL, '2019-10-07 12:13:50'),
(1020, 3, 'محمد محمد عبدالحميد مرعى', '201272965150', NULL, 'mohamed.marey5549@yahoo.com', NULL, 'السويس', 'bridge Engineer', NULL, NULL, NULL, 26, b'0', 'طالب', NULL, '2019-10-07 12:13:50'),
(1021, 3, 'MsEman Dewidar', '1231969034', NULL, 'emydowidar@yahoo.com', NULL, 'إلمنيا', 'Business Development Manager', NULL, NULL, NULL, 27, b'0', 'باحثة ماجستير فى الارشاد اﻷسرى', NULL, '2019-10-07 12:13:50'),
(1022, 3, 'Mohamed mohamed abdelmohsen', '201114429672', NULL, 'm_mohamed211@yahoo.com', NULL, 'إلمنيا', 'موظف', NULL, NULL, NULL, 28, b'0', 'شركه عبر العالم للتوريدات', NULL, '2019-10-07 12:13:50'),
(1023, 3, 'Ahmed Adel amin', '201117005323', NULL, 'ahmed_adel7331@yahoo.com', NULL, 'الدقهلية', 'CEO', NULL, NULL, NULL, 29, b'0', 'موظف في شركه وصله', NULL, '2019-10-07 12:13:50'),
(1024, 3, 'Mohamed Yehia', '201022210906', NULL, 'mohamedyehia801@yahoo.com', NULL, 'القاهرة', 'مهندس', NULL, NULL, NULL, 30, b'1', 'مدير شركه فرست لتوريد العماله والخدمات', NULL, '2019-10-07 12:13:50'),
(1025, 3, 'محمد صبحى محمدغريب', '201012127980', NULL, 'M.sbhy.0366@gMail.com', NULL, 'الجيزة', 'موظف حكومي', NULL, NULL, NULL, 31, b'0', 'ملازم شرف قوات مسلحه بالمعاش', NULL, '2019-10-07 12:13:50'),
(1026, 3, 'Eman ELgohary', '201211303781', NULL, 'ooso_emy2014@yahoo.com', NULL, 'القاهرة', 'Financial &amp; Administrator Manager', NULL, NULL, NULL, 32, b'0', 'اخصائى حاسب الى', NULL, '2019-10-07 12:13:50'),
(1027, 3, 'محمد حسانين احمد حسانين', '201003220639', NULL, 'mohamedhassanin2010@hotmail.com', NULL, 'القاهرة', 'الإدارة', NULL, NULL, NULL, 33, b'0', 'مندوب بشركه لازوردي للمجوهرات', NULL, '2019-10-07 12:13:50'),
(1028, 3, 'علي المصري', '201009455492', NULL, 'ali.adil693@gmail.com', NULL, 'القاهرة', 'مدير مخازن', NULL, NULL, NULL, 34, b'0', 'Product Manager', NULL, '2019-10-07 12:13:50'),
(1029, 3, 'Islam Saeid', '201277845070', NULL, 'eslamsaed1199933@gmail.com', NULL, 'القاهرة', 'مدير مطعم', NULL, NULL, NULL, 35, b'0', 'مستشار تحكيم دولى', NULL, '2019-10-07 12:13:50'),
(1030, 3, 'محمد نعيم', '201231341320', NULL, 'mohammed_na3em2010@yahoo.com', NULL, 'الجيزة', 'Supervisor', NULL, NULL, NULL, 36, b'0', 'فنى تبريد وتكييف', NULL, '2019-10-07 12:13:50'),
(1031, 3, 'Ta Y Ea', '201200380697', NULL, 'pipo.tayaa@yahoo.com', NULL, 'الجيزة', 'سيدة اعمال ومدربة الحياة', NULL, NULL, NULL, 37, b'0', 'طالب', NULL, '2019-10-07 12:13:50'),
(1032, 3, 'Eslam Hawash', '201270119701', NULL, 'eslam_7awash@yahoo.com', NULL, 'القاهرة', 'sales manager', NULL, NULL, NULL, 38, b'0', 'captain order', NULL, '2019-10-07 12:13:50'),
(1033, 3, 'أمل نصار', '201064845952', NULL, 'amlnassar43@gmail.com', NULL, 'القاهرة', 'engineer', NULL, NULL, NULL, 39, b'0', 'تطوع', NULL, '2019-10-07 12:13:50'),
(1034, 3, 'Karim Kosba', '201010171323', NULL, 'karim.2090@yahoo.com', NULL, 'القاهرة', 'مدير مالى', NULL, NULL, NULL, 40, b'1', 'مستشار بالتحيم الدولى', NULL, '2019-10-07 12:13:50'),
(1035, 3, 'أحمد داود', '201062745313', NULL, 'ahmedmassry@rocketmail.com', NULL, 'الشرقية', 'ديوان محافظة نينوى', NULL, NULL, NULL, 41, b'0', 'مساعدصيدلي', NULL, '2019-10-07 12:13:50'),
(1036, 3, 'Hamada Mostafa', '201064269453', NULL, 'abo.trauka@yahoo.com', NULL, 'القاهرة', 'laith', NULL, NULL, NULL, 42, b'0', 'مهندس زراعي', NULL, '2019-10-07 12:13:50'),
(1037, 3, 'Essam Adel', '201001634394', NULL, 'essam_hhh@yahoo.com', NULL, 'القاهرة', 'Maneger', NULL, NULL, NULL, 43, b'0', 'HOtel industry', NULL, '2019-10-07 12:13:50'),
(1038, 3, 'AccAhmed Zanaty', '201063356517', NULL, 'ahmed_ppo@yahoo.com', NULL, 'القاهرة', 'خبيراعشاب', NULL, NULL, NULL, 44, b'0', 'cairo matic', NULL, '2019-10-07 12:13:50'),
(1039, 3, 'محمود احمد محمد حسن', '201121268024', NULL, 'mahmoudsharaky959@yahoo.com', NULL, 'القاهرة', 'ضابط', NULL, NULL, NULL, 45, b'0', 'فنى سباحه', NULL, '2019-10-07 12:13:50'),
(1040, 3, 'Abdelhamid abbas abdelhamid', '201018973508', NULL, 'abdelhamidabbas276@yahoo.com', NULL, 'الغربية', 'Credit Officer', NULL, NULL, NULL, 46, b'0', 'دكتور', NULL, '2019-10-07 12:13:50'),
(1041, 3, 'حوده بندق ابو ياسمين', '201019507496', NULL, 'a_asdasdfirstname@yahoo.com', NULL, 'القاهرة', 'طالب', NULL, NULL, NULL, 47, b'0', 'عامل حر', NULL, '2019-10-07 12:13:50'),
(1042, 3, 'Abdallah fawzy', '201005724694', NULL, 'abdo_alex202025@hotmail.com', NULL, 'الدقهلية', 'senior officer', NULL, NULL, NULL, 48, b'0', 'مدير مشتريات', NULL, '2019-10-07 12:13:50'),
(1043, 3, 'Medhat Rezk', '201091715414', NULL, 'lovelysm22.ll@gmail.com', NULL, 'الدقهلية', 'موظف حكومي', NULL, NULL, NULL, 49, b'0', 'اقرأ وتدبر', NULL, '2019-10-07 12:13:50'),
(1044, 3, 'Amira Hassan Mohamed Hassan', '1024269344', NULL, 'king.lovemero@yahoo.com', NULL, 'الدقهلية', 'trainer', NULL, NULL, NULL, 50, b'1', 'كلية تجارة', NULL, '2019-10-07 12:13:50'),
(1045, 3, 'محمود حيدر', '201004880718', NULL, 'areprinting@gmail.com', NULL, 'مدينة 6 أكتوبر', 'مدير مكتب الخدمات الشاملة', NULL, NULL, NULL, 51, b'0', 'Chairman', NULL, '2019-10-07 12:13:50'),
(1046, 3, 'Mohsen Gerges', '201233832036', NULL, 'mohsen.gerges12@gmail.com', NULL, 'الإسكندرية', 'تجاره', NULL, NULL, NULL, 52, b'0', 'سائق نقل', NULL, '2019-10-07 12:13:50'),
(1047, 3, 'عادل شفيق سعد فرج', '201202866566', NULL, 'romany_o@yahoo.com', NULL, 'القاهرة', 'Jordan High School', NULL, NULL, NULL, 53, b'0', 'محاسب', NULL, '2019-10-07 12:13:50'),
(1048, 3, 'Mohamed El Sayed', '201228012163', NULL, 'fast_dew2003@yahoo.com', NULL, 'القاهرة', 'مهندس اتصالأت', NULL, NULL, NULL, 54, b'0', 'محمد السيد', NULL, '2019-10-07 12:13:50'),
(1049, 3, 'محمدحمدي الانه', '201273752134', NULL, 'cnm021@Yahoo.com', NULL, 'مدينة 6 أكتوبر', 'إدارة الأعمال', NULL, NULL, NULL, 55, b'0', 'في اي حجه', NULL, '2019-10-07 12:13:50'),
(1050, 3, 'Momen Ashraf', '1141077702', NULL, 'momenmemo205@yahoo.com', NULL, 'القاهرة', 'Data Entry', NULL, NULL, NULL, 56, b'0', 'موظف محليات وسكرتير مستشار', NULL, '2019-10-07 12:13:50'),
(1051, 3, 'سامى ممدوح', '201273783097', NULL, 'samy201018@yahoo.com', NULL, 'القاهرة', 'ادراة اعمال', NULL, NULL, NULL, 57, b'0', 'مهندس كمبيوتر وشبكات', NULL, '2019-10-07 12:13:50'),
(1052, 3, 'Alsmany Fon', '249925418737', NULL, 'Ahmedabdrhman55@gmil.com', NULL, 'القاهرة', 'طالب  كلية الادارة والاقتصاد', NULL, NULL, NULL, 58, b'0', 'محامي الوثوق والجنايات الدولية', NULL, '2019-10-07 12:13:50'),
(1053, 3, 'Ayman Elrewiey', '201065528948', NULL, 'aymonty1974@yahoo.com', NULL, 'الدقهلية', 'Owner-operator', NULL, NULL, NULL, 59, b'0', 'Quality Assurance Specialist Internal Auditor', NULL, '2019-10-07 12:13:50'),
(1054, 3, 'Abdo Bahget', '1142035523', NULL, 'yousefelnen@yahoo.com', NULL, 'القاهرة', 'معلمة لغة انجليزية', NULL, NULL, NULL, 60, b'1', 'Student', NULL, '2019-10-07 12:13:50'),
(1055, 3, 'منة الله فضل', '201003892954', NULL, 'sarasalehfadl92@gmail.com', NULL, 'القاهرة', 'الرقابة المالية', NULL, NULL, NULL, 61, b'0', 'معلمة لغة عربية', NULL, '2019-10-07 12:13:50'),
(1056, 3, 'Samy medhat elsayed ali abdo  Elgazar', '201126751676', NULL, 'samyelgazar72@gmail.com', NULL, 'القاهرة', 'لا شيئ', NULL, NULL, NULL, 62, b'0', 'طالب في كلية الحقوق جامعة الاسكندرية', NULL, '2019-10-07 12:13:50'),
(1057, 3, 'مكرم محمد عبدالله الفقي', '201096065145', NULL, 'makramhurgada@yahoo.com', NULL, 'الإسكندرية', 'Key account manager', NULL, NULL, NULL, 63, b'0', 'مساعد مدير مشتريات', NULL, '2019-10-07 12:13:50'),
(1058, 3, 'Khaled Abdelalem', '201116374917', NULL, 'khaled.abooraby@gmail.com', NULL, 'الإسكندرية', 'sales manager', NULL, NULL, NULL, 64, b'0', 'معلم بالتربية والتعليم', NULL, '2019-10-07 12:13:50'),
(1059, 3, 'احمد عطا فارس محمد', '201011961202', NULL, 'ahmad53269@yahoo.com', NULL, 'القاهرة', 'Exceutive Assistant', NULL, NULL, NULL, 65, b'0', 'مشرف اداري', NULL, '2019-10-07 12:13:50'),
(1060, 3, 'Mohamed Khaled', '201140348102', NULL, 'mk01140843102@gmail.com', NULL, 'القاهرة', 'عضو هيئة تدريس بالمعهد الفنى الصناعى بقنا', NULL, NULL, NULL, 66, b'0', 'مخلص بالجمارك', NULL, '2019-10-07 12:13:50'),
(1061, 3, 'Haitham Barakat zekry', '201270243074', NULL, 'jesusshephered@yahoo.com', NULL, 'القاهرة', 'ادارة اعمال', NULL, NULL, NULL, 25, b'0', 'Sohag', NULL, '2019-10-07 12:13:50'),
(1062, 3, 'Mohamed Morsy', '201225964454', NULL, 'mohamed.morsy492@yahoo.com', NULL, 'القاهرة', 'مهندس ميكانيكي', NULL, NULL, NULL, 26, b'0', 'كبير معلمين اللغة العربية', NULL, '2019-10-07 12:13:50'),
(1063, 3, 'على محمد على محمدمحمد رضوان', '201275615034', NULL, 'mano_al_arb_2029@yahoo.com', NULL, 'الجيزة', 'Manager', NULL, NULL, NULL, 27, b'0', 'لا يوجد', NULL, '2019-10-07 12:13:50'),
(1064, 3, 'Mohamed Elbana', '201152282288', NULL, 'fokxfokx@yahoo.com', NULL, 'القاهرة', 'مدير مبيعات', NULL, NULL, NULL, 28, b'1', 'قسم التسويق والمبيعات شركه ببسيكو', NULL, '2019-10-07 12:13:50'),
(1065, 3, 'عمر صابر خميس', '201201742126', NULL, 'omersaper@gmail.com', NULL, 'القليوبية', 'Accountant', NULL, NULL, NULL, 29, b'0', 'مستشار', NULL, '2019-10-07 12:13:50'),
(1066, 3, 'رمضان حمد', '201097976317', NULL, 'rramadanhamad@yahoo.com', NULL, 'بورسعيد', 'مهندس الكترونيات', NULL, NULL, NULL, 30, b'0', 'مدير فرع', NULL, '2019-10-07 12:13:50'),
(1067, 3, 'كرهتك يادنيا', '201012967052', NULL, 'mohmed.elmagek@yahoo.com', NULL, 'القاهرة', 'ادارة وقتصاد', NULL, NULL, NULL, 31, b'0', 'بيع', NULL, '2019-10-07 12:13:50'),
(1068, 3, 'السيد عبدالحميد', '201147424947', NULL, 'alsydbdalhmyd551@gmail.com', NULL, 'القاهرة', 'شؤن إدارية', NULL, NULL, NULL, 32, b'0', 'محاماة', NULL, '2019-10-07 12:13:50'),
(1069, 3, 'Mahmoued Alsony', '201066813045', NULL, 'mahmoudahmed888870@yahoo.com', NULL, 'الجيزة', 'اخصائيه تخاطب', NULL, NULL, NULL, 33, b'0', 'شيف مطعم', NULL, '2019-10-07 12:13:50'),
(1070, 3, 'سامح منصور', '201026615376', NULL, 'samhm9224@gmail.com', NULL, 'مدينة 6 أكتوبر', 'Owner', NULL, NULL, NULL, 34, b'0', 'مدرب كلاب للحراسة والمفرقعات', NULL, '2019-10-07 12:13:50'),
(1071, 3, 'Abo Hamza', '201001744715', NULL, 'mm10020094@yahoo.com', NULL, 'الجيزة', 'موظف', NULL, NULL, NULL, 35, b'0', 'مشرف مدنى', NULL, '2019-10-07 12:13:50'),
(1072, 3, 'بسام محمد سيد محمد شعبان', '201113665689', NULL, 'basam_bob2002@yahoo.com', NULL, 'القاهرة', 'مهندسة', NULL, NULL, NULL, 36, b'0', 'Studying', NULL, '2019-10-07 12:13:50'),
(1073, 3, 'Nancy Mamdouh Samy', '201279968831', NULL, 'name_name300@yahoo.com', NULL, 'القاهرة', 'programing', NULL, NULL, NULL, 37, b'0', 'الاستاذه', NULL, '2019-10-07 12:13:50'),
(1074, 3, 'Shiko Shimo', '201026263301', NULL, 'shimaaahmedahmed961@yahoo.com', NULL, 'الجيزة', 'gamoudi', NULL, NULL, NULL, 38, b'1', 'تمهيدى ماجستير legal researcher diplom of public law', NULL, '2019-10-07 12:13:50'),
(1075, 3, 'Islam Mondy', '201110066653', NULL, 'islamondi@gmail.com', NULL, 'القاهرة', 'doctor', NULL, NULL, NULL, 39, b'0', 'islam sayed', NULL, '2019-10-07 12:13:50'),
(1076, 3, 'Abo Ahmed', '201096313414', NULL, 'diaa_abdelgelel2015@yahoo.com', NULL, 'القاهرة', 'سكرتارية تنفيذية', NULL, NULL, NULL, 40, b'0', 'صاحب مكتب مقاولات عامه وتشطيبات', NULL, '2019-10-07 12:13:50'),
(1077, 3, 'اشرف العارف الصعيدي', '213911611016', NULL, 'a.970@Gmail.com', NULL, 'الجيزة', 'اعمال حرة', NULL, NULL, NULL, 41, b'0', 'مستشار', NULL, '2019-10-07 12:13:50'),
(1078, 3, 'Hanan Almhde', '201143953802', NULL, 'alshamsnoor22@yahoo.com', NULL, 'القاهرة', 'Manger', NULL, NULL, NULL, 42, b'0', 'حنان', NULL, '2019-10-07 12:13:50'),
(1079, 3, 'Mohammed Mahmoud', '201015210086', NULL, 'mohammed.mhamoud@yahoo.com', NULL, 'القاهرة', 'account msnager', NULL, NULL, NULL, 43, b'0', 'وصيانه الطابعات', NULL, '2019-10-07 12:13:50'),
(1080, 3, 'فارس الدين', '201025741058', NULL, 'aus_aus93@yahoo.com', NULL, 'القاهرة', 'business manager', NULL, NULL, NULL, 44, b'0', 'فني اجهزه دقيقه', NULL, '2019-10-07 12:13:50'),
(1081, 3, 'محمود العيسوى', '201061944372', NULL, 'mahmoudsamara582@yahoo.com', NULL, 'الجيزة', 'physician', NULL, NULL, NULL, 45, b'0', 'الثنويه الصناعيه', NULL, '2019-10-07 12:13:50'),
(1082, 3, 'حسن فتحي عبداللاه محمد', '201022316087', NULL, 'hassan.hassan201423@yahoo.com', NULL, 'السويس', 'موظف', NULL, NULL, NULL, 46, b'0', 'السيد المستشار', NULL, '2019-10-07 12:13:50'),
(1083, 3, 'Zizo El Ghazzawi', '201024443088', NULL, 'anawadmodmen@yahoo.com', NULL, 'السويس', 'موطف اداري', NULL, NULL, NULL, 47, b'0', 'مصمم جرافيك', NULL, '2019-10-07 12:13:50'),
(1084, 3, 'Eng Mohammed', '9647708163318', NULL, 'mohammedabd626@yahoo.com', NULL, 'القاهرة', 'GM.', NULL, NULL, NULL, 48, b'1', 'Engineer', NULL, '2019-10-07 12:13:50'),
(1085, 3, 'شارب بيره ومخاوي اميره', '201158822316', NULL, 'dalo713@yahoo.com', NULL, 'الإسكندرية', 'مهندس', NULL, NULL, NULL, 49, b'0', 'كلام فى الحب', NULL, '2019-10-07 12:13:50'),
(1086, 3, 'محمود عبدالقادر سيد أحمد محمود', '1066838919', NULL, 'ganam_ganam79@yahoo.com', NULL, 'القاهرة', 'مهندس', NULL, NULL, NULL, 50, b'0', 'محكم دولى', NULL, '2019-10-07 12:13:50'),
(1087, 3, 'Mahmoud Mesbah', '201003664780', NULL, 'sword_mah2010@yahoo.com', NULL, 'الإسكندرية', 'sales manager', NULL, NULL, NULL, 51, b'0', 'English teacher', NULL, '2019-10-07 12:13:50'),
(1088, 3, 'محمد جمعه متولى', '1111363408', NULL, 'aymangomaa12@gmail.com', NULL, 'الجيزة', 'لا اعمل حاليا ولما هشتغل هقولك انت اول واحد', NULL, NULL, NULL, 52, b'0', 'طالب بكليه تجاره', NULL, '2019-10-07 12:13:50'),
(1089, 3, 'محمد نعمان محمد نعمان أبو العز', '201004561171', NULL, 'mohamed.noman71@yahoo.com', NULL, 'القاهرة', 'Engineer', NULL, NULL, NULL, 53, b'0', 'فني', NULL, '2019-10-07 12:13:50'),
(1090, 3, 'Mohamed Jo', '201112930371', NULL, 'mohamedjo@yahoo.com', NULL, 'القاهرة', 'مرشد تربوي', NULL, NULL, NULL, 54, b'0', 'مستشار', NULL, '2019-10-07 12:13:50'),
(1091, 3, 'Ali Khattab', '1148183691', NULL, 'alikhattab98@yahoo.com', NULL, 'القاهرة', 'مدرس', NULL, NULL, NULL, 55, b'0', 'ليساني اداب', NULL, '2019-10-07 12:13:50'),
(1092, 3, 'Abdelrahman Elamin Hamid', '201110321456', NULL, 'abdulrhmansd3@gmail.com', NULL, 'الدقهلية', 'داري', NULL, NULL, NULL, 56, b'0', 'فني كهرباى', NULL, '2019-10-07 12:13:50'),
(1093, 3, 'Sam Mohamed Elfakia', '1211253160', NULL, 'samnsagdg@gmail.com', NULL, 'القاهرة', 'Mathematics Teacher', NULL, NULL, NULL, 57, b'0', 'محاره', NULL, '2019-10-07 12:13:50'),
(1094, 3, 'Mohamed Eldesouky Mano', '201273076363', NULL, 'modedode51@yahoo.com', NULL, 'القاهرة', 'تنقاش وحاصل علي ليسانس لغة عربية', NULL, NULL, NULL, 58, b'1', 'بائع', NULL, '2019-10-07 12:13:50'),
(1095, 3, 'Samir Fekry', '201065694329', NULL, 'Notenough2010@gmail.com', NULL, 'القاهرة', 'دكتورة في ادارة الاعمال', NULL, NULL, NULL, 59, b'0', 'هيئة قضائية عليا', NULL, '2019-10-07 12:13:50'),
(1096, 3, 'Ashraf Awaad', '201099775587', NULL, 'ashraf_awaad20@yahoo.com', NULL, 'القاهرة', 'Supervisore', NULL, NULL, NULL, 60, b'0', 'FOOD&amp;BEVARAGE MGR', NULL, '2019-10-07 12:13:50'),
(1097, 3, 'Shenouda Mahrous showky', '201229450130', NULL, 'mnashyoyo@yahoo.com', NULL, 'القاهرة', 'مدير مبيعات', NULL, NULL, NULL, 61, b'0', 'نائب مديرالصيانه بقريه سياحيه', NULL, '2019-10-07 12:13:50'),
(1098, 3, 'Abanoub Magdy', '201211428263', NULL, 'abanoubmagdy12355@gmail.com', NULL, 'الإسكندرية', 'خبير الأمراض الجلديةوأمراض الذكورة', NULL, NULL, NULL, 62, b'0', 'طالب بكلية الحقوق', NULL, '2019-10-07 12:13:50'),
(1099, 3, 'Abdalaa Sabeh', '201272377860', NULL, 'abdalaa.sabeh@yahoo.com', NULL, 'القاهرة', 'مدير تسويق ومحكم دولى معتمد', NULL, NULL, NULL, 63, b'0', 'مهندس', NULL, '2019-10-07 12:13:50'),
(1100, 3, 'حسن السقا', '201275062679', NULL, 'hassanha370@yahoo.com', NULL, 'القاهرة', 'متخرج بشهادة دبلوم عالي في مجال إدارة الأعمال', NULL, NULL, NULL, 64, b'0', 'سائق', NULL, '2019-10-07 12:13:50'),
(1101, 3, 'Mohamed Elsheshtawy', '201201555086', NULL, 'mohamed_sheshtawy18@yahoo.com', NULL, 'القاهرة', 'اعمال حرةا', NULL, NULL, NULL, 65, b'0', 'معلم لغه انجليزيه', NULL, '2019-10-07 12:13:50'),
(1102, 3, 'Sameh Awed', '201024924762', NULL, 'vandersameh@yahoo.com', NULL, 'المنوفية', 'استاذ ثانوي', NULL, NULL, NULL, 66, b'0', 'sameh', NULL, '2019-10-07 12:13:50'),
(1103, 3, 'Joe Nagy', '1222325800', NULL, 'joenagy75@yahoo.com', NULL, 'القاهرة', 'مهندس برمجيات', NULL, NULL, NULL, 25, b'0', 'حاصل على الثانوية العامه و ادرس فى كلية تجارة', NULL, '2019-10-07 12:13:50'),
(1104, 3, 'محمد بو حسين', '201200032670', NULL, 'aaa.kh123@yahoo.com', NULL, 'القاهرة', 'Certified Sales Executive', NULL, NULL, NULL, 26, b'1', 'شركة مقاولات', NULL, '2019-10-07 12:13:50'),
(1105, 3, 'محمد الجمال', '201027080469', NULL, 'me425817@gmail.com', NULL, 'القاهرة', 'مهندس كهرباء', NULL, NULL, NULL, 27, b'0', 'صاحب كافيه', NULL, '2019-10-07 12:13:50'),
(1106, 3, 'سمسم الجنتل', '201274964172', NULL, 'osama1421998@yahoo.com', NULL, 'القاهرة', 'موطف الشوؤن الادارية', NULL, NULL, NULL, 28, b'0', 'مهندس لحام', NULL, '2019-10-07 12:13:50'),
(1107, 3, 'Ibrahim Nabil', '201220432564', NULL, 'ibrahim.nabil750@gmail.com', NULL, 'القاهرة', 'طبيب', NULL, NULL, NULL, 29, b'0', 'فني تشغيل وصيانه الغلايات البخاريه وتكيف وتبريد', NULL, '2019-10-07 12:13:50'),
(1108, 3, 'احمد السعيد الجوهرى', '1090218838', NULL, 'Ahmed.elsaeid24@Yahoo.com', NULL, 'القاهرة', 'بكالريوس تربية', NULL, NULL, NULL, 30, b'0', 'طالب في الازهر', NULL, '2019-10-07 12:13:50'),
(1109, 3, 'محمد احمد محمود', '201015497128', NULL, 'kasem_m59@yahoo.com', NULL, 'الجيزة', 'طالب', NULL, NULL, NULL, 31, b'0', 'مهندس برمجيات', NULL, '2019-10-07 12:13:50'),
(1110, 3, 'احمد ابومهند', '966585398157', NULL, 'mohamadking376@yahoo.com', NULL, 'بورسعيد', 'Sales Supervisor', NULL, NULL, NULL, 32, b'0', 'اعمال حرة', NULL, '2019-10-07 12:13:50'),
(1111, 3, 'Mohammed Saeed Omar', '201226305704', NULL, 'mohammedsaidomer@yahoo.com', NULL, 'القاهرة', 'مشرف تربوي', NULL, NULL, NULL, 33, b'0', 'معلم لغة عربية', NULL, '2019-10-07 12:13:50'),
(1112, 3, 'Moataz Alaa', '201110051145', NULL, 'Elkoptan.moataz@yahoo.com', NULL, 'القاهرة', 'ادارة الاعمال', NULL, NULL, NULL, 34, b'0', 'طالب', NULL, '2019-10-07 12:13:50'),
(1113, 3, 'اسامه محمد حسن احمد', '201100436776', NULL, 'asd.2020.asd95@yahoo.com', NULL, 'القاهرة', 'محامي', NULL, NULL, NULL, 35, b'0', 'عامل', NULL, '2019-10-07 12:13:50'),
(1114, 3, 'Ahmed Shahin', '201060779071', NULL, 'ahmedshahin777@yahoo.com', NULL, 'القاهرة', 'English teacher', NULL, NULL, NULL, 36, b'1', 'طالب', NULL, '2019-10-07 12:13:50'),
(1115, 3, 'Mahmoud Abdelfatah mahmoud ghanem', '201201218434', NULL, 'medo_gh2006@yahoo.com', NULL, 'الدقهلية', 'assistant employee relation officer', NULL, NULL, NULL, 37, b'0', 'طالب', NULL, '2019-10-07 12:13:50'),
(1116, 3, 'عبدالله على', '1147899947', NULL, 'manabdo560@yahoo.com', NULL, 'القاهرة', 'Doctor', NULL, NULL, NULL, 38, b'0', 'العدل بين الناس', NULL, '2019-10-07 12:13:50'),
(1117, 3, 'رومانى.بشارة.جاد.السيد', '201226795639', NULL, 'romahy@16.rom.com', NULL, 'الإسكندرية', 'صاحب شركه اجهزه كهربيه', NULL, NULL, NULL, 39, b'0', 'مهارات الدراسة.حاصل.على.دبلوم.زراعة', NULL, '2019-10-07 12:13:50'),
(1118, 3, 'ابراهيم احمد ابراهيم', '201009930347', NULL, 'ebrahimroma3@gmail.com', NULL, 'الجيزة', 'موظف حكومي', NULL, NULL, NULL, 40, b'0', 'محامى', NULL, '2019-10-07 12:13:50'),
(1119, 3, 'علي محمد علي حسن', '201233420808', NULL, 'alialkomy333@gmail.com', NULL, 'القاهرة', 'موظف', NULL, NULL, NULL, 41, b'0', 'حاصل علي دبلوم زراعه', NULL, '2019-10-07 12:13:50'),
(1120, 3, 'عبدالستار هاشم عبد الكريم خليفة', '213927673229', NULL, 'www.sunpop36@gmail.com', NULL, 'القاهرة', 'tetcher', NULL, NULL, NULL, 42, b'0', 'مقاول', NULL, '2019-10-07 12:13:50'),
(1121, 3, 'Ahmad Abolhsan', '201201015601', NULL, 'ahmadaboelhsan@gmail.com', NULL, 'الجيزة', 'مهندس كمبيوتر ومحاضر', NULL, NULL, NULL, 43, b'0', 'Trabajador', NULL, '2019-10-07 12:13:50'),
(1122, 3, 'محمد الشربيني', '201090808072', NULL, 'mohamedsherbo22@gmail.com', NULL, 'القاهرة', 'Engineer', NULL, NULL, NULL, 44, b'0', 'محامي', NULL, '2019-10-07 12:13:50'),
(1123, 3, 'Islam Shaheen', '1144480880', NULL, 'islam697@yahoo.com', NULL, 'القاهرة', 'General Supervisor', NULL, NULL, NULL, 45, b'0', 'محاسب', NULL, '2019-10-07 12:13:50'),
(1124, 3, 'كريم عصام محمود عياد', '201010379021', NULL, 'kimoelzaem@yahoo.com', NULL, 'القاهرة', 'امين مستودع', NULL, NULL, NULL, 46, b'1', 'مستشار فى التحكيم الاسرى', NULL, '2019-10-07 12:13:50'),
(1125, 3, 'ابوالشوق كادلك', '201098478060', NULL, 'mohamedshawky847@yahoo.com', NULL, 'القاهرة', 'Associate Director Enterprises Development', NULL, NULL, NULL, 47, b'0', 'ممثل', NULL, '2019-10-07 12:13:50'),
(1126, 3, 'Adel Amin', '1027976196', NULL, 'adelamin1968@yahoo.com', NULL, 'القاهرة', 'سكرتير', NULL, NULL, NULL, 48, b'0', 'كفتة فىروسات', NULL, '2019-10-07 12:13:50'),
(1127, 3, 'Seif Ashraf', '201065757988', NULL, 'saifashraf442@yahoo.com', NULL, 'القاهرة', 'Project assisrant', NULL, NULL, NULL, 49, b'0', 'Dj/ Producer Mixer', NULL, '2019-10-07 12:13:50'),
(1128, 3, 'Mostafa Ali', '1200357973', NULL, 'alaslam34000@yahoo.com', NULL, 'القاهرة', 'Legislative Assistant', NULL, NULL, NULL, 50, b'0', 'Oil Petrosannan company', NULL, '2019-10-07 12:13:50'),
(1129, 3, 'طارق حسنى مهدى متولى', '201210857537', NULL, 'tarekteko354@gmail.com', NULL, 'القاهرة', 'محاسب', NULL, NULL, NULL, 51, b'0', 'سائق شاحنةمعدات ثقيله', NULL, '2019-10-07 12:13:50'),
(1130, 3, 'Mohammed Abd Elrahem Samy', '201019757799', NULL, 'toson18@gmail.com', NULL, 'الجيزة', 'لا رصاد الجوي', NULL, NULL, NULL, 52, b'0', 'خدمات مساعده بالبنك الاهلي المصري', NULL, '2019-10-07 12:13:50'),
(1131, 3, 'بسكوته حسن', '201206000364', NULL, 'yari66642@yahoo.com', NULL, 'القاهرة', 'Head of Sales &amp; Leasing', NULL, NULL, NULL, 53, b'0', 'عضو', NULL, '2019-10-07 12:13:50'),
(1132, 3, 'الشيخ عبده أبو هلاله', '201018745050', NULL, 'abdoawad_1974@yahoo.com', NULL, 'الدقهلية', 'student', NULL, NULL, NULL, 54, b'0', 'ايمام وخطيب ومدرس اول', NULL, '2019-10-07 12:13:50'),
(1133, 3, 'Ebrahim Sabry Abdelrhman', '96550872720', NULL, 'e_heartmagic_75@yahoo.com', NULL, 'القاهرة', 'Product Manager', NULL, NULL, NULL, 55, b'0', 'sells man', NULL, '2019-10-07 12:13:50'),
(1134, 3, 'سید کبیشہ', '201002349695', NULL, 'bas.said@yahoo.com', NULL, 'القاهرة', 'Joinery manager', NULL, NULL, NULL, 56, b'1', 'مهندس حاسب آلى', NULL, '2019-10-07 12:13:50'),
(1135, 3, 'Nagy Ahmed ALrifhy', '1212268843', NULL, 'admmnaagy@gmail.com', NULL, 'القاهرة', 'فني اتصالات', NULL, NULL, NULL, 57, b'0', 'فني صيانة', NULL, '2019-10-07 12:13:50'),
(1136, 3, 'مصطفى محمد محمود مصطفى غنيم', '201224433962', NULL, 'mostafaghoniem@gmail.com', NULL, 'الجيزة', 'مهندس كيمياءي', NULL, NULL, NULL, 58, b'0', 'ضابط شرطة', NULL, '2019-10-07 12:13:50'),
(1137, 3, 'ايمن زلط', '201210153182', NULL, 'zalat39@yahoo.com', NULL, 'القاهرة', 'فنان تشكيلي... منسق الفنون البصرية', NULL, NULL, NULL, 59, b'0', 'حاصل علي دبلوم فني تجاري', NULL, '2019-10-07 12:13:50'),
(1138, 3, 'رامي مصطفي', '201062080344', NULL, 'ramyr665@yahoo.com', NULL, 'القاهرة', 'Nursing Manager', NULL, NULL, NULL, 60, b'0', 'وكيل معتمدفودافون', NULL, '2019-10-07 12:13:50'),
(1139, 3, 'Waled Elfwahry', '201009140770', NULL, 'x_man3031@yahoo.com', NULL, 'القاهرة', 'Colonel', NULL, NULL, NULL, 61, b'0', 'ضابط امن', NULL, '2019-10-07 12:13:50'),
(1140, 3, 'El Mezoghi Adel', '201062293889', NULL, 'a.aaadel@yahoo.com', NULL, 'القاهرة', 'Designer', NULL, NULL, NULL, 62, b'0', 'مستشار قانوني', NULL, '2019-10-07 12:13:50'),
(1141, 3, 'abeer mahmoud mohamed ali', '201028731884', NULL, 'abeermohmoud@yahoo.com', NULL, 'الجيزة', 'LA .Architect', NULL, NULL, NULL, 63, b'0', 'مصممة فوتوشوب', NULL, '2019-10-07 12:13:50'),
(1142, 3, 'وليد العمده', '201200119697', NULL, 'waleedelsofany@yahoo.com', NULL, 'الإسكندرية', 'مهندس', NULL, NULL, NULL, 64, b'0', 'وليد محمد', NULL, '2019-10-07 12:13:50'),
(1143, 3, 'Hamza Mohemad Mohy', '201120521372', NULL, 'mdmpop_pepo@yahoo.com', NULL, 'الإسكندرية', 'تاجر', NULL, NULL, NULL, 65, b'0', 'عامل حر', NULL, '2019-10-07 12:13:50'),
(1144, 3, 'ياسر عزت', '201005385031', NULL, 'yaserazzat@yahoi.com', NULL, 'القاهرة', 'Financial Analyst', NULL, NULL, NULL, 66, b'1', 'ديلوم صنايع وصاحب مكتب مقاولات', NULL, '2019-10-07 12:13:50'),
(1145, 3, 'محمد أحمد  حمودة', '201159287289', NULL, 'mhamouda720@gmail.com', NULL, 'القاهرة', 'م.ملاحظ', NULL, NULL, NULL, 25, b'0', 'صاحب مكتب استيراد وتصدير', NULL, '2019-10-07 12:13:50'),
(1146, 3, 'على السيد علي محمد', '201068058079', NULL, 'abobadr47@yahoo.com', NULL, 'الجيزة', 'مدرس', NULL, NULL, NULL, 26, b'0', 'مهندس زراعي بشركه النوران للسكر', NULL, '2019-10-07 12:13:50'),
(1147, 3, 'Yaser Alsmahy', '201231680188', NULL, 'yasora55@yahoo.com', NULL, 'الجيزة', 'f', NULL, NULL, NULL, 27, b'0', 'معلم نظري زخرفه واعلان', NULL, '2019-10-07 12:13:50'),
(1148, 3, 'احمدالسيدمحمدعقيلة', '1021123325', NULL, 'akila0500@gmail.com', NULL, 'القاهرة', 'لا يوجد', NULL, NULL, NULL, 28, b'0', 'Product Manager', NULL, '2019-10-07 12:13:50'),
(1149, 3, 'Mohamed hamd', '201125493532', NULL, 'mohamed_hamed2200@yahoo.com', NULL, 'الجيزة', 'إدارة المراجعة', NULL, NULL, NULL, 29, b'0', 'الكليه التكنولوجيه بالمطريه', NULL, '2019-10-07 12:13:50'),
(1150, 3, 'Mahmoud Ahmad Agwa', '966541677212', NULL, 'mahmoudagwa503@yahoo.com', NULL, 'القاهرة', 'محاسب', NULL, NULL, NULL, 30, b'0', 'Supervisor', NULL, '2019-10-07 12:13:50'),
(1151, 3, 'Khaled Elhadarey', '201110679166', NULL, 'kelhadsrey@yshoo.com', NULL, 'الإسكندرية', 'مدير تسويق ومبيعات', NULL, NULL, NULL, 31, b'0', 'ضابط ملازم اول بالفوات الجويه بالمعاش', NULL, '2019-10-07 12:13:50'),
(1152, 3, 'Ahmed Samir ahmed', '201020009132', NULL, 'ah.samir2020@gmail.com', NULL, 'الجيزة', 'Concierge Services', NULL, NULL, NULL, 32, b'0', 'General Administration of Trade Services', NULL, '2019-10-07 12:13:50'),
(1153, 3, 'Akram Ghrib', '201224222076', NULL, 'akramghrib28@gmail.com', NULL, 'إلمنيا', 'منتج نشرات اخبارية', NULL, NULL, NULL, 33, b'0', 'مدير مركز عزبة البرج للعلاج الطبيعي..رئيس قسم الجوده والاعتماد مستشفى كفر البطيخ المركزي', NULL, '2019-10-07 12:13:50'),
(1154, 3, 'Mahmoud Abo Omr', '201018726450', NULL, 'modelove604@gmail.com', NULL, 'القاهرة', 'Technical Fiber Optics', NULL, NULL, NULL, 34, b'1', 'حاصل ع دبلوم', NULL, '2019-10-07 12:13:50'),
(1155, 3, 'Ahmed Hmdy', '201009698839', NULL, 'ahmed_hmdy_2007@yahoo.com', NULL, 'الجيزة', 'Lecturer', NULL, NULL, NULL, 35, b'0', 'Training', NULL, '2019-10-07 12:13:50'),
(1156, 3, 'Ahmed Mido', '201092131743', NULL, 'medorere89@yahoo.com', NULL, 'القاهرة', 'مدير عام برنامج &quot; صناعة التاجر &quot; الريادي', NULL, NULL, NULL, 36, b'0', 'Ahmed', NULL, '2019-10-07 12:13:50'),
(1157, 3, 'عادل صلاح الليثي', '201027113035', NULL, 'adelellithy85@gmil.com', NULL, 'الإسكندرية', 'مدير عام', NULL, NULL, NULL, 37, b'0', 'مدير مكتب نقل ثقيل', NULL, '2019-10-07 12:13:50'),
(1158, 3, 'Mohamed Ali', '201090835276', NULL, 'alim35074@gmail.com', NULL, 'القليوبية', 'مهندس زراعى', NULL, NULL, NULL, 38, b'0', 'Slickline operator@EGOSCO,PETROBEL', NULL, '2019-10-07 12:13:50'),
(1159, 3, 'mohammed alnady', '1201521101', NULL, 'alnady2020@yahoo.com', NULL, 'القاهرة', 'مدير جمعيه خيريه', NULL, NULL, NULL, 39, b'0', 'السيد المستشار الفاضل', NULL, '2019-10-07 12:13:50'),
(1160, 3, 'Ahmed Sobhaeyy', '201222816945', NULL, 'ahmedsobheyy@yahoo.com', NULL, 'القاهرة', 'Project Manager', NULL, NULL, NULL, 40, b'0', 'مدير مطعم', NULL, '2019-10-07 12:13:50'),
(1161, 3, 'Marwà Ezz Elden', '201016208011', NULL, 'marwa_ezz92@yahoo.com', NULL, 'القاهرة', 'المدير العام', NULL, NULL, NULL, 41, b'0', '111992', NULL, '2019-10-07 12:13:50'),
(1162, 3, 'Doaa Shawqi', '201025556647', NULL, 'doniadody589@yahoo.com', NULL, 'القاهرة', 'Manager', NULL, NULL, NULL, 42, b'0', 'اخصائى اسواق مالية', NULL, '2019-10-07 12:13:50'),
(1163, 3, 'Mody Mo', '201004811178', NULL, 'modykg1computer@yahoo.com', NULL, 'القاهرة', 'diploma', NULL, NULL, NULL, 43, b'0', 'Sales', NULL, '2019-10-07 12:13:50'),
(1164, 3, 'Osama Elmasry', '201152802828', NULL, 'elmasry0mm@yahoo.com', NULL, 'القاهرة', 'لاتوجد', NULL, NULL, NULL, 44, b'1', 'صاحب شركه الاستثمار العقاري والمقاولات العامه', NULL, '2019-10-07 12:13:50'),
(1165, 3, 'Ahmed Abdel Nasser', '201004915963', NULL, 'alshayeb.com94@yahoo.com', NULL, 'القاهرة', 'فنى خراط', NULL, NULL, NULL, 45, b'0', 'مهندس حاسب', NULL, '2019-10-07 12:13:50'),
(1166, 3, 'شريف حمدى', '201142204490', NULL, 'sherif.hamdy@sescotrans.gmail', NULL, 'القاهرة', 'رقيب', NULL, NULL, NULL, 46, b'0', 'محاسب', NULL, '2019-10-07 12:13:50'),
(1167, 3, 'Mohamed Aboelkhair', '1002500522', NULL, 'mohamedaboelkhair@yahoo.com', NULL, 'القاهرة', 'مدير مشروع  بدون شهادات', NULL, NULL, NULL, 47, b'0', 'مكافحة التهرب الضريبي بضرائب المبيعات', NULL, '2019-10-07 12:13:50'),
(1168, 3, 'Nancy Abosamra', '201060121229', NULL, 'didi_ragab@hotmail.com', NULL, 'الإسكندرية', 'مندوب مبيعات', NULL, NULL, NULL, 48, b'0', 'مستشاره', NULL, '2019-10-07 12:13:50'),
(1169, 3, 'رامبو رامبو', '201128697911', NULL, 'sexs77777@yahoo.com', NULL, 'القاهرة', 'مدير موارد بشرية وشؤون ادارية', NULL, NULL, NULL, 49, b'0', 'مستشار', NULL, '2019-10-07 12:13:50'),
(1170, 3, 'Mohamed ashraf', '201004393353', NULL, 'momobo55@yahoo.com', NULL, 'القاهرة', 'طالب جامعة', NULL, NULL, NULL, 50, b'0', 'مدير  و صاحب', NULL, '2019-10-07 12:13:50'),
(1171, 3, 'احمد سيد', '201118572637', NULL, 'ahmed_sayd733@yahoo.com', NULL, 'القاهرة', 'شركة راز الطبية قسم قسطرة القلب - مجموعة راز القابضة - حاضنات الأعمال , احدى شركات الزامل', NULL, NULL, NULL, 51, b'0', 'مساعد طباع', NULL, '2019-10-07 12:13:50'),
(1172, 3, 'بودى عشاب', '201013783304', NULL, 'boody.ash84@yahoo.com', NULL, 'القاهرة', 'Manager', NULL, NULL, NULL, 52, b'0', 'مديرمبيعات', NULL, '2019-10-07 12:13:50'),
(1173, 3, 'مغلق للتحسينات', '201111392184', NULL, 'yaseensay@yahoo.com', NULL, 'القاهرة', 'مساعدطبيب', NULL, NULL, NULL, 53, b'0', 'منسق', NULL, '2019-10-07 12:13:50'),
(1174, 3, 'Hosny Hasan', '201146692350', NULL, 'hosnyalodary@yahoo.com', NULL, 'القاهرة', 'محاضر', NULL, NULL, NULL, 54, b'1', 'معلم اول لغه عربيه', NULL, '2019-10-07 12:13:50'),
(1175, 3, 'نصر عبدالسﻻم', '1224027176', NULL, 'nasr_elmetwaly@yahoo.com', NULL, 'القاهرة', 'مدير إداري', NULL, NULL, NULL, 55, b'0', 'مدرس لغة عربية', NULL, '2019-10-07 12:13:50'),
(1176, 3, 'ﻣﻴﻨﺎ لوزي رياض عطايه', '201069095263', NULL, 'mina123411@yahoo.com', NULL, 'الإسكندرية', 'محاسب', NULL, NULL, NULL, 56, b'0', 'وكيل', NULL, '2019-10-07 12:13:50'),
(1177, 3, 'محمدعبد الفتاح محمد', '201001209679', NULL, 'hmadaalwzer@yahoo.com', NULL, 'القاهرة', 'Administrator', NULL, NULL, NULL, 57, b'0', 'تربية وتعليم', NULL, '2019-10-07 12:13:50');
INSERT INTO `customercrm` (`customerCrmId`, `addedby`, `customerCrmName`, `customerCrmPhone`, `customerCrmSecondPhone`, `customerCrmEmail`, `customerCrmCompany`, `customerCrmGov`, `customerCrmJob`, `customerCrmQualification`, `customerCrmCountry`, `customerCrmAddress`, `customerCrmAge`, `customerCrmGender`, `customerCrmActivity`, `customerCrmOther`, `customerCrmCreateDate`) VALUES
(1178, 3, 'محمد عيسى عبد السلام عبداللطيف قنديل', '201124661646', NULL, 'mohamedkandel034@gmail.com', NULL, 'الجيزة', 'CNC OPERATOR CUM PROGRAMMER', NULL, NULL, NULL, 58, b'0', 'مشرف او ملاحظ فى تشغيل المكينات', NULL, '2019-10-07 12:13:50'),
(1179, 3, 'Mohamed Abd Elkader', '201010883561', NULL, 'monelove493@yahoo.com', NULL, 'القاهرة', 'مندوب مببعات', NULL, NULL, NULL, 59, b'0', 'مهندس', NULL, '2019-10-07 12:13:50'),
(1180, 3, 'اسلام القصاص', '1002482471', NULL, 'islam_agor@yahoo.com', NULL, 'القاهرة', 'Hr', NULL, NULL, NULL, 60, b'0', 'مستشار فى هايئة تحكيم الدولة', NULL, '2019-10-07 12:13:50'),
(1181, 3, 'الاعلامى أحمد الحسينى', '201027590546', NULL, 'ahmed.el7seny@yahoo.com', NULL, 'القاهرة', 'اخصائي تسويق', NULL, NULL, NULL, 61, b'0', 'مقدم برامج تلفزيونية', NULL, '2019-10-07 12:13:50'),
(1182, 3, 'عمرو خالد', '201208028922', NULL, 'afrekan00@yahoo.com', NULL, 'القاهرة', 'اعمال حرة', NULL, NULL, NULL, 62, b'0', 'حكم', NULL, '2019-10-07 12:13:50'),
(1183, 3, 'Hussein Amin', '201149431910', NULL, 'abo.amin22@hotmail.com', NULL, 'القاهرة', 'Account Manager', NULL, NULL, NULL, 63, b'0', 'علاقات عامة', NULL, '2019-10-07 12:13:50'),
(1184, 3, 'ZiZo Abden', '201150907570', NULL, 'zizo_abden_10@yahoo.com', NULL, 'القاهرة', 'gm', NULL, NULL, NULL, 64, b'1', 'طالب كليه حقوق جامعه حلوان', NULL, '2019-10-07 12:13:50'),
(1185, 3, 'Abrehm Mhmwed Abrehm', '201017958725', NULL, 'hh0108092353@yahoo.com', NULL, 'القاهرة', 'لا يوجد', NULL, NULL, NULL, 65, b'0', 'رجل اعمال', NULL, '2019-10-07 12:13:50'),
(1186, 3, 'وليد محمد عبدالرحمن عبدالجليل', '201025026700', NULL, 'walidmari1@hotmail.com', NULL, 'القاهرة', 'Founder', NULL, NULL, NULL, 66, b'0', 'محاسب', NULL, '2019-10-07 12:13:50'),
(1187, 3, 'الشيخ حاتم نبيه', '201062365651', NULL, 'ado_hasn@yahoo.com', NULL, 'القاهرة', 'رجل اعمال', NULL, NULL, NULL, 25, b'0', 'معلم اول خبير فى التعليم الصناعى', NULL, '2019-10-07 12:13:50'),
(1188, 3, 'Ahmed Fouad', '201237465802', NULL, 'tito_fouash@yahoo.com', NULL, 'القاهرة', 'Lecturer', NULL, NULL, NULL, 26, b'0', 'شئون ادراية', NULL, '2019-10-07 12:13:50'),
(1189, 3, 'حسام حسن', '201098663660', NULL, 'hk_111_11_1@yahoo.com', NULL, 'القاهرة', 'اعمل في مستشفى الملك فهد المركزي بجيزان.', NULL, NULL, NULL, 27, b'0', 'سكرتير تحقيق', NULL, '2019-10-07 12:13:50'),
(1190, 3, 'Hanibalsadekelafune Elafune', '201125236457', NULL, '5hanebalitours@gmail.com', NULL, 'الجيزة', 'مندوب اعلانات', NULL, NULL, NULL, 28, b'0', 'مشرف حركه بشركة اي تورز للسياحه', NULL, '2019-10-07 12:13:50'),
(1191, 3, 'Dola Fawzy', '201017154872', NULL, 'dolafawzy_nolove@yahoo.com', NULL, 'القاهرة', 'مدير فرع', NULL, NULL, NULL, 29, b'0', 'طالب', NULL, '2019-10-07 12:13:50'),
(1192, 3, 'Gasser Mohamed', '201202032002#01005408660', NULL, 'gasserw2002@yahoo.com', NULL, 'القاهرة', 'Sales Consultant', NULL, NULL, NULL, 30, b'0', 'صاحب مكتب استيراد وتصدير', NULL, '2019-10-07 12:13:50'),
(1193, 3, 'محمد سامي محمد رضوان', '201225956951', NULL, 'bosho99@yahoo.com', NULL, 'القاهرة', 'مدير', NULL, NULL, NULL, 31, b'0', 'شيف كريب', NULL, '2019-10-07 12:13:50'),
(1194, 3, 'محمود بودافون', '201112508489', NULL, 'midofone2014@yahoo.com', NULL, 'القاهرة', 'Sounir. Engneer.  Civil', NULL, NULL, NULL, 32, b'1', 'صاحب مؤسسه', NULL, '2019-10-07 12:13:50'),
(1195, 3, 'عصام السعيد محمد السعيد', '201200540405', NULL, 'layaly51@hotmail.com', NULL, 'الجيزة', 'Project Manager', NULL, NULL, NULL, 33, b'0', 'رئيس الوقود', NULL, '2019-10-07 12:13:50'),
(1196, 3, 'Mohamed Mosstafa', '201232838256', NULL, 'memo2010_541@hotmail.com', NULL, 'الجيزة', 'pharmacist', NULL, NULL, NULL, 34, b'0', 'محاسب', NULL, '2019-10-07 12:13:50'),
(1197, 3, 'Aya Nasr', '1095701340', NULL, 'nasraya918@yahoo.com', NULL, 'القاهرة', 'صاحب مؤسسه', NULL, NULL, NULL, 35, b'0', 'تالته ثانوي عام', NULL, '2019-10-07 12:13:50'),
(1198, 3, 'مينا موريس', '201121660558', NULL, 'minamorees@live.com', NULL, 'الجيزة', 'مدير الموارد البشريه', NULL, NULL, NULL, 36, b'0', 'مينا موريس', NULL, '2019-10-07 12:13:50'),
(1199, 3, 'Hossiny Ebrhim', '201004193428', NULL, 'bassmala_2003@yahoo.com', NULL, 'القاهرة', 'موظف', NULL, NULL, NULL, 37, b'0', 'N/Aاخصائى دراسات وبحوث اقتصادية اول', NULL, '2019-10-07 12:13:50'),
(1200, 3, 'samy abd elwahab elazb', '1145629999', NULL, 'samyelazb@yahoo.com', NULL, 'القاهرة', 'المهندس', NULL, NULL, NULL, 38, b'0', 'رجل أعمال', NULL, '2019-10-07 12:13:50'),
(1201, 3, 'Aiman Mohamed Darweash', '201001508510', NULL, 'al.darweash@yahoo.com', NULL, 'القاهرة', 'Managing Editor', NULL, NULL, NULL, 39, b'0', 'صاحب مؤسسة تجاريه', NULL, '2019-10-07 12:13:50'),
(1202, 3, 'Hsham Magdy', '1114678257', NULL, 'hsham_tito@yahoo.com', NULL, 'القاهرة', 'مستشار - عضو هيئة تدريس', NULL, NULL, NULL, 40, b'0', 'طالب بكليه حقوق جامعه المنوفيه', NULL, '2019-10-07 12:13:50'),
(1203, 3, 'Hassan El Ashry', '201061414333', NULL, 'elhareef_e@yahoo.com', NULL, 'القاهرة', 'مدير تجاري', NULL, NULL, NULL, 41, b'0', 'Manager', NULL, '2019-10-07 12:13:50'),
(1204, 3, 'Kareem Gomaa', '201090298845', NULL, 'krym.jwm@mail.ru', NULL, 'القاهرة', 'وكيل مدرسة', NULL, NULL, NULL, 42, b'1', 'وكيل النائب العام', NULL, '2019-10-07 12:13:50'),
(1205, 3, 'وائل فتحى فواد', '201224614534', NULL, 'waelfathy768@Yahoo.com', NULL, 'الجيزة', 'كاتب', NULL, NULL, NULL, 43, b'0', 'مقاول', NULL, '2019-10-07 12:13:50'),
(1206, 3, 'Adel Nagaty', '1279447881', NULL, 'adlnjaty@gmail.com', NULL, 'القاهرة', 'استاذ', NULL, NULL, NULL, 44, b'0', 'محامي', NULL, '2019-10-07 12:13:50'),
(1207, 3, 'حودة شاكر', '201201013872', NULL, 'hoda_eldod47@yahoo.com', NULL, 'الإسكندرية', 'CEO', NULL, NULL, NULL, 45, b'0', 'محل فريده للاحذيه والشنط الحريمي', NULL, '2019-10-07 12:13:50'),
(1208, 3, 'احمد محمود حميد محمود احمد', '201207309027', NULL, 'wwwAhmedalotaiby890@yahoo.com', NULL, 'القاهرة', 'لايوجد', NULL, NULL, NULL, 46, b'0', 'ﻻ إله إلا الله محمد رسول الله', NULL, '2019-10-07 12:13:50'),
(1209, 3, 'Ahmed Ayman', '201277495053', NULL, 'madaa550@yahoo.com', NULL, 'البحيرة', 'م', NULL, NULL, NULL, 47, b'0', 'محامي', NULL, '2019-10-07 12:13:50'),
(1210, 3, 'Cap Abdallah Atc', '201211138375', NULL, 'baloobaloo244@yahoo.com', NULL, 'الدقهلية', 'مدير الابتعاث', NULL, NULL, NULL, 48, b'0', 'at cairo airport', NULL, '2019-10-07 12:13:50'),
(1211, 3, 'Ȝłį Ĕšmý ßǿy-ẌǷƿ', '201111844256', NULL, 'mahmoudbayo96@yahoo.com', NULL, 'القاهرة', 'مدير عام الشركة', NULL, NULL, NULL, 49, b'0', 'Interior Designer/Decorator', NULL, '2019-10-07 12:13:50'),
(1212, 3, 'Eslam hassan hassan mohamed morgan', '201220452220', NULL, 'eslamhassan239@gmail.com', NULL, 'القاهرة', 'بروفيسور', NULL, NULL, NULL, 50, b'0', 'eslam morgan', NULL, '2019-10-07 12:13:50'),
(1213, 3, 'احمد عبدالله', '201227241440', NULL, 'ahmevip305@gmail.com', NULL, 'الجيزة', 'المدير التنفيذي', NULL, NULL, NULL, 51, b'0', 'مهندس الكترونيات', NULL, '2019-10-07 12:13:50'),
(1214, 3, 'Selfraz Nassar', '201228804623', NULL, 'selfraz.nassar@gmail.com', NULL, 'القاهرة', 'موظف', NULL, NULL, NULL, 52, b'1', 'محاسب', NULL, '2019-10-07 12:13:50'),
(1215, 3, 'Essam Aladhm', '201237703726', NULL, 'essamaladhm11@yahoo.com', NULL, 'القاهرة', 'Quality Control Supervisor', NULL, NULL, NULL, 53, b'0', 'مشراف العام  فى  قرية سياحية', NULL, '2019-10-07 12:13:50'),
(1216, 3, 'Ahmed Hassan', '201011608517', NULL, 'Zezo_fire_love@yahoo.com', NULL, 'القاهرة', 'بين المداد والكراس', NULL, NULL, NULL, 54, b'0', 'Sailor', NULL, '2019-10-07 12:13:50'),
(1217, 3, 'محمد حسين حماده حسين', '201019165292', NULL, 'mido2010_man2010@yahoo.com', NULL, 'الجيزة', 'Operations Manager', NULL, NULL, NULL, 55, b'0', 'طالب بكليه تربيه العريش', NULL, '2019-10-07 12:13:50'),
(1218, 3, 'انس العقباوى', '201021085585', NULL, 'anas_anas10530@yahoo.com', NULL, 'الإسكندرية', 'Ophthalmologist', NULL, NULL, NULL, 56, b'0', 'انس', NULL, '2019-10-07 12:13:50'),
(1219, 3, 'Abdala Mahamd', '201140331161', NULL, 'Andala.mahamd@yam.com', NULL, 'القاهرة', 'Technical Account Manager', NULL, NULL, NULL, 57, b'0', 'Engineer', NULL, '2019-10-07 12:13:50'),
(1220, 3, 'Murad Salah', '201147595000', NULL, 'moradsalah1010@yahoo.com', NULL, 'القاهرة', 'مدير التنفيدي', NULL, NULL, NULL, 58, b'0', 'طالب جامعي', NULL, '2019-10-07 12:13:50'),
(1221, 3, 'م.عمرو عبدالفتاح', '1275429739', NULL, 'Fawzy22333@yohoo.com', NULL, 'الجيزة', 'Electrical Engineer', NULL, NULL, NULL, 59, b'0', 'مهندس', NULL, '2019-10-07 12:13:50'),
(1222, 3, 'حماده رفعت الداودى فوده', '201144210485', NULL, 'hamadarefaat00@gmail.com', NULL, 'الجيزة', 'عمال حره', NULL, NULL, NULL, 60, b'0', 'حاصل على دبلوم صناعى معمارى', NULL, '2019-10-07 12:13:50'),
(1223, 3, 'احمد فتحى سعد', '1238353320', NULL, 'elkpt@hotmail.com', NULL, 'الجيزة', 'Director general', NULL, NULL, NULL, 61, b'0', 'علاقات عامة واعلام', NULL, '2019-10-07 12:13:50'),
(1224, 3, 'Koka Tota', '1229020624', NULL, 'hagerkoka72@yahoo.com', NULL, 'الإسكندرية', 'Supervisor', NULL, NULL, NULL, 62, b'1', 'حاصله ع ليسنس حقوق', NULL, '2019-10-07 12:13:50'),
(1225, 3, 'ﻣﺤﻤﺪ ﻣﺤﻤﻮﺩ نورالدين', '201002902646', NULL, 'am516873@gmail.com', NULL, 'القاهرة', 'بكالوريوس علم الاجتماع السياسي', NULL, NULL, NULL, 63, b'0', 'دبلوم صنايع', NULL, '2019-10-07 12:13:50'),
(1226, 3, 'خلف جمال محمد شحات', '1011038254', NULL, 'khalafgamal559@yahoo.com', NULL, 'القاهرة', 'Veterinarian', NULL, NULL, NULL, 64, b'0', 'طالب في كلية الصيدله', NULL, '2019-10-07 12:13:50'),
(1227, 3, 'Sameh Kenawy.سامح محمد قناوى سالم', '201154332283', NULL, 'samehkenawy365@yahoo.com', NULL, 'القاهرة', 'موارد بشرية', NULL, NULL, NULL, 65, b'0', 'فنى بشركه مياه الشرب والصرف الصحي باسوان', NULL, '2019-10-07 12:13:50'),
(1228, 3, 'Mahmoud Shaaban', '201111828829', NULL, 'mahmoud.shaaban.africana@gmail.com', NULL, 'الجيزة', 'محاسب', NULL, NULL, NULL, 66, b'0', 'Manager', NULL, '2019-10-07 12:13:50'),
(1229, 3, 'Mazen Elmogy', '201023007970', NULL, 'wageh12551@gmail.com', NULL, 'الجيزة', 'Account Manager', NULL, NULL, NULL, 25, b'0', 'محاسب مالي', NULL, '2019-10-07 12:13:50'),
(1230, 3, 'Esam Elrayes', '201273272325', NULL, 'esam_elrayes@yahoo.com', NULL, 'الجيزة', 'مفاولات', NULL, NULL, NULL, 26, b'0', 'موظف', NULL, '2019-10-07 12:13:50'),
(1231, 3, 'Äňă Ăļ Wăđ Føx', '1118247329', NULL, 'ahmedfox2324@yahoo.com', NULL, 'القاهرة', 'Accountant', NULL, NULL, NULL, 27, b'0', 'Product Manager', NULL, '2019-10-07 12:13:50'),
(1232, 3, 'Hocy Esmail', '201277706262', NULL, 'hossnni6@gmail.com', NULL, 'القاهرة', 'أستشاري موارد بشرية ومدير التدريب الأداري', NULL, NULL, NULL, 28, b'0', 'free businees', NULL, '2019-10-07 12:13:50'),
(1233, 3, 'Asim El-Daly', '201000212879', NULL, 'assem_adel@hotmail.com', NULL, 'القاهرة', 'مدير مشاريع في مؤسسة قطاع خاص', NULL, NULL, NULL, 29, b'0', 'Project Manager', NULL, '2019-10-07 12:13:50'),
(1234, 3, 'احمد منير مصطفى', '201122583892', NULL, 'mohamedmonirhack@yahoo.com', NULL, 'القاهرة', 'Human Resources Manager', NULL, NULL, NULL, 30, b'1', 'وزير الصحة', NULL, '2019-10-07 12:13:50'),
(1235, 3, 'Mostafa Tamem', '201099735975', NULL, 'tam_em_88@hotmail.com', NULL, 'القاهرة', 'وكيل شؤون تعليمية لمدرسة ثانوية', NULL, NULL, NULL, 31, b'0', 'as acustomer service Agent.', NULL, '2019-10-07 12:13:50'),
(1236, 3, 'Amr Gamal', '201060464917', NULL, 'amrelsheikh2014@gmail.com', NULL, 'القاهرة', 'محاسب', NULL, NULL, NULL, 32, b'0', 'مهندس برمجيات', NULL, '2019-10-07 12:13:50'),
(1237, 3, 'Sea Row', '201208185175', NULL, 'sarahsaleh365@gmail.com', NULL, 'القاهرة', 'Translator/Interpreter', NULL, NULL, NULL, 33, b'0', 'ساره عبد الحكم', NULL, '2019-10-07 12:13:50'),
(1238, 3, 'عفيفي احمد عفيفي مصطفى', '201140609130', NULL, 'aboafify_2012@yahoo.com', NULL, 'الإسكندرية', 'محاسب', NULL, NULL, NULL, 34, b'0', 'موزع ادوات منزليه', NULL, '2019-10-07 12:13:50'),
(1239, 3, 'يوسف وهايدى عبد العال', '201117482643', NULL, 'Yousoof12345446@gmail.com', NULL, 'القليوبية', 'engineer', NULL, NULL, NULL, 35, b'0', 'بكالوريوس تجارة', NULL, '2019-10-07 12:13:50'),
(1240, 3, 'محمد ابراهيم', '1062006667', NULL, 'mo6010@yahoo.com', NULL, 'الإسكندرية', 'general manager', NULL, NULL, NULL, 36, b'0', 'قطاع شئون مكتب وزير........', NULL, '2019-10-07 12:13:50'),
(1241, 3, 'Karim Keshoo', '1144622218', NULL, 'kkarim734@yahoo.com', NULL, 'الإسماعيلية', 'pharmacist', NULL, NULL, NULL, 37, b'0', 'طاه', NULL, '2019-10-07 12:13:50'),
(1242, 3, 'Mohamed ALi', '201225659507', NULL, 'aboyossef125@yahoo.com', NULL, 'القاهرة', 'ممرضه', NULL, NULL, NULL, 38, b'0', 'محاسب ايرادات', NULL, '2019-10-07 12:13:50'),
(1243, 3, 'Mohamed Yousef', '201271019966', NULL, 'wmw017@yahoo.com', NULL, 'القاهرة', 'مدير مالي', NULL, NULL, NULL, 39, b'0', 'Supervisor', NULL, '2019-10-07 12:13:50'),
(1244, 3, 'Ahmed Elsherif', '201000595230', NULL, 'ahmedelsherif39@yahoo.com', NULL, 'الجيزة', 'محصل', NULL, NULL, NULL, 40, b'1', 'طالب', NULL, '2019-10-07 12:13:50'),
(1245, 3, 'Fathe Esa', '201201912173', NULL, 'fathe_esa@yahoo.com', NULL, 'الجيزة', 'اخصاءية تدريب', NULL, NULL, NULL, 41, b'0', 'مهندس', NULL, '2019-10-07 12:13:50'),
(1246, 3, 'شيرين محمد محمد راشد', '201144022252', NULL, 'ali.foural@gmail.com', NULL, 'القاهرة', 'طلب جمعي', NULL, NULL, NULL, 42, b'0', 'رءيس وحده بشركه السويس لتصنيع البترول', NULL, '2019-10-07 12:13:50'),
(1247, 3, 'مجدى عبد الرحيم', '201111156114', NULL, 'magdyabdelrhim@outlook.com', NULL, 'القاهرة', 'Manager', NULL, NULL, NULL, 43, b'0', 'مدير العلاقات العامة والاعلام', NULL, '2019-10-07 12:13:50'),
(1248, 3, 'Elbasha Khater', '201001144913', NULL, 'elbasha_elbasha1239@yahoo.com', NULL, 'القاهرة', 'رجل اعمال', NULL, NULL, NULL, 44, b'0', 'مدير توكيل السيارات', NULL, '2019-10-07 12:13:50'),
(1249, 3, 'Awad Eid', '962793239470', NULL, 'aboeid45@yahoo.com', NULL, 'القاهرة', 'مصلح حاسبات وموبيلات', NULL, NULL, NULL, 45, b'0', 'ميش عارف', NULL, '2019-10-07 12:13:50'),
(1250, 3, 'Mohamed Fakhry', '1007210213', NULL, 'm.fakhry1173@gmail.com', NULL, 'القاهرة', 'حقل البيضاء', NULL, NULL, NULL, 46, b'0', 'مهندس', NULL, '2019-10-07 12:13:50'),
(1251, 3, 'Fares Magdy Almaz', '201206263990', NULL, 'fares.almaz@yahoo.com', NULL, 'القاهرة', 'محقق', NULL, NULL, NULL, 47, b'0', 'Alxendaria', NULL, '2019-10-07 12:13:50'),
(1252, 3, 'هاني وديع', '201062424155', NULL, 'dode.hani@yahoo.com', NULL, 'القاهرة', 'موظف', NULL, NULL, NULL, 48, b'0', 'اخصائي إجتماعي بمكتب الخدمة المدرسية بإدارة الداخلة التعليمية', NULL, '2019-10-07 12:13:50'),
(1253, 3, 'Eman Diab', '201008381075', NULL, 'emyd72a@gmail.com', NULL, 'القاهرة', 'Assistant Claims Manager', NULL, NULL, NULL, 49, b'0', 'Teacher معلم اول الف', NULL, '2019-10-07 12:13:50'),
(1254, 3, 'Heba Ali', '201201926604', NULL, 'a.heba47@yahoo.com', NULL, 'القاهرة', 'مو ظيفي', NULL, NULL, NULL, 50, b'1', 'accounting', NULL, '2019-10-07 12:13:50'),
(1255, 3, 'Mahmoud Sobhy', '201226440029', NULL, 'fox_movx@yahoo.com', NULL, 'القاهرة', 'Customer Service Associate (CSA)', NULL, NULL, NULL, 51, b'0', 'شيف', NULL, '2019-10-07 12:13:50'),
(1256, 3, 'Ahmed Mohamed Ahmed Selim', '201005167632', NULL, 'Ahmedslim2009@hotmail.com', NULL, 'الإسكندرية', 'مدير مبيعات', NULL, NULL, NULL, 52, b'0', 'Department Head', NULL, '2019-10-07 12:13:50'),
(1257, 3, 'سلطان زمانه', '201063502304', NULL, 'ahmed_mido8117@yahoo.com', NULL, 'مدينة 6 أكتوبر', 'مدرس', NULL, NULL, NULL, 53, b'0', 'سياحة وفنادق', NULL, '2019-10-07 12:13:50'),
(1258, 3, 'شمس اﻻمل', '201012371460', NULL, 'nona2015160@yahoo.com', NULL, 'مدينة 6 أكتوبر', 'CEO', NULL, NULL, NULL, 54, b'0', 'حاصلة على ليسانس حقوق وﻻ أعمل', NULL, '2019-10-07 12:13:50'),
(1259, 3, 'ميشيل مدحت', '122601178', NULL, 'mishomedhat@yahoo.com', NULL, 'الجيزة', 'مركز خدمة الزبائن', NULL, NULL, NULL, 55, b'0', 'النجم المشع', NULL, '2019-10-07 12:13:50'),
(1260, 3, 'Ibrahim Hima', '201026644483', NULL, 'himaboge25@gmail.com', NULL, 'الجيزة', 'Civil eng', NULL, NULL, NULL, 56, b'0', 'مساعد صيدليه', NULL, '2019-10-07 12:13:50'),
(1261, 3, 'Nasser Abdullah Abderrady', '201149621000', NULL, 'nasserabohazem1971@gmail.com', NULL, 'القاهرة', 'مساعد مهندس', NULL, NULL, NULL, 57, b'0', 'مقاول', NULL, '2019-10-07 12:13:50'),
(1262, 3, 'احمد شوقى محمد حامد', '201222583808', NULL, 'ahmedshowky544@yahoo.com', NULL, 'القاهرة', 'مدرس', NULL, NULL, NULL, 58, b'0', 'محاسب', NULL, '2019-10-07 12:13:50'),
(1263, 3, 'Alaa Hussein', '201110757983', NULL, 'alaa1kiki@gmail.com', NULL, 'القاهرة', 'مدير عام', NULL, NULL, NULL, 59, b'0', 'ليسانس حقوق', NULL, '2019-10-07 12:13:50'),
(1264, 3, 'الله المستعان على ماتصفون', '201154742020', NULL, 'hh1966066@gmail.com', NULL, 'مدينة 6 أكتوبر', 'رئيس قسم التوثيق وتقنية المعلومات بجهاز الاسعاف', NULL, NULL, NULL, 60, b'1', 'محاسب مالي', NULL, '2019-10-07 12:13:50'),
(1265, 3, 'السيد محمد علي محمد', '201270003410', NULL, 'wo45037@gmail.com', NULL, 'مدينة 6 أكتوبر', 'أعمال حره', NULL, NULL, NULL, 61, b'0', 'حرفي شركة إﻻسكندرية لتويع الكهرباء', NULL, '2019-10-07 12:13:50'),
(1266, 3, 'ابراهيم مصطفي الدغيدي', '201126052334', NULL, 'ebrahimmostafa422@gmail.com', NULL, 'القاهرة', 'فندق', NULL, NULL, NULL, 62, b'0', 'حاصل على ليسانس حقوق جامعة الزقازيق', NULL, '2019-10-07 12:13:50'),
(1267, 3, 'Mohamed Hussein Moustafa', '201006825752', NULL, 'mohamed.hussein2011@yahoo.com', NULL, 'الجيزة', 'سكرتير', NULL, NULL, NULL, 63, b'0', 'طبيب بيطري', NULL, '2019-10-07 12:13:50'),
(1268, 3, 'Mohumed Shams Hussin', '201065532301', NULL, 'shaws_shaws2000@yahoo.com', NULL, 'القاهرة', 'خريج وابحث عن وظيفة', NULL, NULL, NULL, 64, b'0', 'مستشار', NULL, '2019-10-07 12:13:50'),
(1269, 3, 'Mohammed Fouad', '201002845153', NULL, 'fokshbasha_2006@hotmail.com', NULL, 'القاهرة', 'طالب جامعي', NULL, NULL, NULL, 65, b'0', 'super vizer', NULL, '2019-10-07 12:13:50'),
(1270, 3, 'Mohamed Saleh', '201000545266', NULL, 'original201394@yahoo.com', NULL, 'القاهرة', 'موظف حكومي', NULL, NULL, NULL, 66, b'0', 'مسؤل مبيعات', NULL, '2019-10-07 12:13:50'),
(1271, 3, 'Mohamed Yahia', '201018629899', NULL, 'mygaa2002@gmail.com', NULL, 'القاهرة', 'مندوب مبيعات', NULL, NULL, NULL, 25, b'0', 'مصمم', NULL, '2019-10-07 12:13:50'),
(1272, 3, 'Casper Wade', '201090100526', NULL, 'm_mod44@yahoo.com', NULL, 'العاشر من رمضان', 'مدير مشروع', NULL, NULL, NULL, 26, b'0', 'متخصص امن', NULL, '2019-10-07 12:13:50'),
(1273, 3, 'Sameh Kamal', '201063159262', NULL, 'kamalsameh771@yahoo.com', NULL, 'القاهرة', 'it programmer', NULL, NULL, NULL, 27, b'0', 'محامي', NULL, '2019-10-07 12:13:50'),
(1274, 3, 'Âhmêd Wêêkâ', '201099806623', NULL, 'ahmedlovely2014@yahoo.com', NULL, 'القاهرة', 'كاسب', NULL, NULL, NULL, 28, b'1', 'احمد عبد العزيز', NULL, '2019-10-07 12:13:50'),
(1275, 3, 'Mohamed Sayed', '201147964052', NULL, 'mody.50650@yahoo.com', NULL, 'الإسكندرية', 'مدير عام شركه', NULL, NULL, NULL, 29, b'0', 'مشرف عام', NULL, '2019-10-07 12:13:50'),
(1276, 3, 'محمد حماصه', '201146667831', NULL, 'thhamasa@yahoo.com', NULL, 'الجيزة', 'عضو هيئة تدريس', NULL, NULL, NULL, 30, b'0', 'مهندس برمجيات', NULL, '2019-10-07 12:13:50'),
(1277, 3, 'Esraa Elnakib', '201235884235', NULL, 'israaelnakib@yahoo.com', NULL, 'القاهرة', 'وزير مفوص الخارجية الليبية', NULL, NULL, NULL, 31, b'0', 'محاميه', NULL, '2019-10-07 12:13:50'),
(1278, 3, 'احمد حسن عبد العزيز محمد', '201277649467', NULL, 'Ahmed.hassan274@yahoo.com', NULL, 'القاهرة', 'مقاولات عامة', NULL, NULL, NULL, 32, b'0', 'إدارة', NULL, '2019-10-07 12:13:50'),
(1279, 3, 'Mohamed Hamza', '201224800045', NULL, 'hamzaweyyyyy@gmail.com', NULL, 'القاهرة', 'مقاتل', NULL, NULL, NULL, 33, b'0', 'مدير مالي', NULL, '2019-10-07 12:13:50'),
(1280, 3, 'Hossam Abd Alzaher', '201113208002', NULL, 'safe_elfares@yahoo.com', NULL, 'القاهرة', 'إدارة مكتب', NULL, NULL, NULL, 34, b'0', 'مراجع مرتبات بالبريد', NULL, '2019-10-07 12:13:50'),
(1281, 3, 'ام حفص وجويرية احمد', '201017739829', NULL, 'ahmedkamel3456@yahoo.com', NULL, 'الجيزة', 'صحفي', NULL, NULL, NULL, 35, b'0', 'معلمة', NULL, '2019-10-07 12:13:50'),
(1282, 3, 'بلال مجدي', '201093251361', NULL, 'fhghhh@yahoo.com', NULL, 'الجيزة', 'تاجر', NULL, NULL, NULL, 36, b'0', 'مستشار', NULL, '2019-10-07 12:13:50'),
(1283, 45, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 1, b'1', '1', '1', '2019-10-10 11:46:55');

-- --------------------------------------------------------

--
-- Table structure for table `customerproductcrm`
--

CREATE TABLE `customerproductcrm` (
  `customerProductId` int(11) NOT NULL,
  `customerId` int(11) NOT NULL,
  `prouductCrmId` int(11) NOT NULL,
  `createDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employees_tasks`
--

CREATE TABLE `employees_tasks` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `supervisor_ID` int(11) DEFAULT NULL,
  `clientID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Status` int(11) NOT NULL,
  `Distributor_By` int(11) DEFAULT NULL,
  `redirect` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees_tasks`
--

INSERT INTO `employees_tasks` (`id`, `userID`, `supervisor_ID`, `clientID`, `Date`, `Time`, `Status`, `Distributor_By`, `redirect`) VALUES
(511, 47, 44, 642, '2019-10-07', '06:05:49', 1, 3, b'1'),
(512, 47, 44, 643, '2019-10-07', '06:05:49', 1, 3, b'1'),
(513, 47, 44, 644, '2019-10-07', '06:05:49', 1, 3, b'0'),
(514, 47, 44, 645, '2019-10-07', '06:05:49', 1, 3, b'0'),
(515, 47, 44, 646, '2019-10-07', '06:05:49', 1, 3, b'0'),
(516, 47, 44, 647, '2019-10-07', '06:05:49', 1, 3, b'0'),
(517, 47, 44, 648, '2019-10-07', '06:05:49', 1, 3, b'0'),
(518, 47, 44, 649, '2019-10-07', '06:05:49', 1, 3, b'0'),
(519, 47, 44, 650, '2019-10-07', '06:05:49', 1, 3, b'1'),
(520, 47, 44, 651, '2019-10-07', '06:05:49', 1, 3, b'0'),
(521, 44, NULL, 652, '2019-10-07', '12:15:56', 1, 3, b'0'),
(522, 44, NULL, 653, '2019-10-07', '12:15:56', 1, 3, b'0'),
(523, 44, NULL, 654, '2019-10-07', '12:15:56', 1, 3, b'0'),
(524, 44, NULL, 655, '2019-10-07', '12:15:56', 1, 3, b'0'),
(525, 44, NULL, 656, '2019-10-07', '12:15:56', 1, 3, b'0'),
(526, 44, NULL, 657, '2019-10-07', '12:15:56', 1, 3, b'0'),
(527, 44, NULL, 658, '2019-10-07', '12:15:56', 1, 3, b'0'),
(528, 44, NULL, 659, '2019-10-07', '12:15:56', 1, 3, b'0'),
(529, 44, NULL, 660, '2019-10-07', '12:15:56', 1, 3, b'0'),
(530, 44, NULL, 661, '2019-10-07', '12:15:56', 1, 3, b'0'),
(531, 44, NULL, 662, '2019-10-07', '12:15:56', 1, 3, b'0'),
(532, 44, NULL, 663, '2019-10-07', '12:15:56', 1, 3, b'0'),
(533, 44, NULL, 664, '2019-10-07', '12:15:56', 1, 3, b'0'),
(534, 44, NULL, 665, '2019-10-07', '12:15:56', 1, 3, b'0'),
(535, 44, NULL, 666, '2019-10-07', '12:15:56', 1, 3, b'0'),
(536, 44, NULL, 667, '2019-10-07', '12:15:56', 1, 3, b'0'),
(537, 44, NULL, 668, '2019-10-07', '12:15:56', 1, 3, b'0'),
(538, 44, NULL, 669, '2019-10-07', '12:15:56', 1, 3, b'0'),
(539, 44, NULL, 670, '2019-10-07', '12:15:56', 1, 3, b'0'),
(540, 44, NULL, 671, '2019-10-07', '12:15:56', 1, 3, b'0'),
(541, 44, NULL, 672, '2019-10-07', '12:15:56', 1, 3, b'0'),
(542, 44, NULL, 673, '2019-10-07', '12:15:56', 1, 3, b'0'),
(543, 44, NULL, 674, '2019-10-07', '12:15:56', 1, 3, b'0'),
(544, 44, NULL, 675, '2019-10-07', '12:15:56', 1, 3, b'0'),
(545, 44, NULL, 676, '2019-10-07', '12:15:56', 1, 3, b'0'),
(546, 44, NULL, 677, '2019-10-07', '12:15:56', 1, 3, b'0'),
(547, 44, NULL, 678, '2019-10-07', '12:15:56', 1, 3, b'0'),
(548, 44, NULL, 679, '2019-10-07', '12:15:56', 1, 3, b'0'),
(549, 44, NULL, 680, '2019-10-07', '12:15:56', 1, 3, b'0'),
(550, 44, NULL, 681, '2019-10-07', '12:15:56', 1, 3, b'0'),
(551, 44, NULL, 682, '2019-10-07', '12:15:56', 1, 3, b'0'),
(552, 44, NULL, 683, '2019-10-07', '12:15:56', 1, 3, b'0'),
(553, 44, NULL, 684, '2019-10-07', '12:15:56', 1, 3, b'0'),
(554, 44, NULL, 685, '2019-10-07', '12:15:56', 1, 3, b'0'),
(555, 44, NULL, 686, '2019-10-07', '12:15:56', 1, 3, b'0'),
(556, 44, NULL, 687, '2019-10-07', '12:15:56', 1, 3, b'0'),
(557, 44, NULL, 688, '2019-10-07', '12:15:56', 1, 3, b'0'),
(558, 44, NULL, 689, '2019-10-07', '12:15:56', 1, 3, b'0'),
(559, 44, NULL, 690, '2019-10-07', '12:15:56', 1, 3, b'0'),
(560, 44, NULL, 691, '2019-10-07', '12:15:56', 1, 3, b'0'),
(561, 44, NULL, 692, '2019-10-07', '12:15:56', 1, 3, b'0'),
(562, 44, NULL, 693, '2019-10-07', '12:15:56', 1, 3, b'0'),
(563, 44, NULL, 694, '2019-10-07', '12:15:56', 1, 3, b'0'),
(564, 44, NULL, 695, '2019-10-07', '12:15:56', 1, 3, b'0'),
(565, 44, NULL, 696, '2019-10-07', '12:15:56', 1, 3, b'0'),
(566, 44, NULL, 697, '2019-10-07', '12:15:56', 1, 3, b'0'),
(567, 44, NULL, 698, '2019-10-07', '12:15:56', 1, 3, b'0'),
(568, 44, NULL, 699, '2019-10-07', '12:15:56', 1, 3, b'0'),
(569, 44, NULL, 700, '2019-10-07', '12:15:56', 1, 3, b'0'),
(570, 44, NULL, 701, '2019-10-07', '12:15:56', 1, 3, b'0'),
(571, 44, NULL, 702, '2019-10-07', '12:15:56', 1, 3, b'0'),
(572, 44, NULL, 703, '2019-10-07', '12:15:56', 1, 3, b'0'),
(573, 44, NULL, 704, '2019-10-07', '12:15:56', 1, 3, b'0'),
(574, 44, NULL, 705, '2019-10-07', '12:15:56', 1, 3, b'0'),
(575, 44, NULL, 706, '2019-10-07', '12:15:56', 1, 3, b'0'),
(576, 44, NULL, 707, '2019-10-07', '12:15:56', 1, 3, b'0'),
(577, 44, NULL, 708, '2019-10-07', '12:15:56', 1, 3, b'0'),
(578, 44, NULL, 709, '2019-10-07', '12:15:56', 1, 3, b'0'),
(579, 44, NULL, 710, '2019-10-07', '12:15:56', 1, 3, b'0'),
(580, 44, NULL, 711, '2019-10-07', '12:15:56', 1, 3, b'0'),
(581, 44, NULL, 712, '2019-10-07', '12:15:56', 1, 3, b'0'),
(582, 44, NULL, 713, '2019-10-07', '12:15:56', 1, 3, b'0'),
(583, 44, NULL, 714, '2019-10-07', '12:15:56', 1, 3, b'0'),
(584, 44, NULL, 715, '2019-10-07', '12:15:56', 1, 3, b'0'),
(585, 44, NULL, 716, '2019-10-07', '12:15:56', 1, 3, b'0'),
(586, 44, NULL, 717, '2019-10-07', '12:15:56', 1, 3, b'0'),
(587, 44, NULL, 718, '2019-10-07', '12:15:56', 1, 3, b'0'),
(588, 44, NULL, 719, '2019-10-07', '12:15:56', 1, 3, b'0'),
(589, 44, NULL, 720, '2019-10-07', '12:15:56', 1, 3, b'0'),
(590, 44, NULL, 721, '2019-10-07', '12:15:56', 1, 3, b'0'),
(591, 44, NULL, 722, '2019-10-07', '12:15:56', 1, 3, b'0'),
(592, 44, NULL, 723, '2019-10-07', '12:15:56', 1, 3, b'0'),
(593, 44, NULL, 724, '2019-10-07', '12:15:56', 1, 3, b'0'),
(594, 44, NULL, 725, '2019-10-07', '12:15:56', 1, 3, b'0'),
(595, 44, NULL, 726, '2019-10-07', '12:15:56', 1, 3, b'0'),
(596, 44, NULL, 727, '2019-10-07', '12:15:56', 1, 3, b'0'),
(597, 44, NULL, 728, '2019-10-07', '12:15:56', 1, 3, b'0'),
(598, 44, NULL, 729, '2019-10-07', '12:15:56', 1, 3, b'0'),
(599, 44, NULL, 730, '2019-10-07', '12:15:56', 1, 3, b'0'),
(600, 44, NULL, 731, '2019-10-07', '12:15:56', 1, 3, b'0'),
(601, 44, NULL, 732, '2019-10-07', '12:15:56', 1, 3, b'0'),
(602, 44, NULL, 733, '2019-10-07', '12:15:56', 1, 3, b'0'),
(603, 44, NULL, 734, '2019-10-07', '12:15:56', 1, 3, b'0'),
(604, 44, NULL, 735, '2019-10-07', '12:15:56', 1, 3, b'0'),
(605, 44, NULL, 736, '2019-10-07', '12:15:56', 1, 3, b'0'),
(606, 44, NULL, 737, '2019-10-07', '12:15:56', 1, 3, b'0'),
(607, 44, NULL, 738, '2019-10-07', '12:15:56', 1, 3, b'0'),
(608, 44, NULL, 739, '2019-10-07', '12:15:56', 1, 3, b'0'),
(609, 44, NULL, 740, '2019-10-07', '12:15:56', 1, 3, b'0'),
(610, 44, NULL, 741, '2019-10-07', '12:15:56', 1, 3, b'0'),
(611, 44, NULL, 742, '2019-10-07', '12:15:56', 1, 3, b'0'),
(612, 44, NULL, 743, '2019-10-07', '12:15:56', 1, 3, b'0'),
(613, 44, NULL, 744, '2019-10-07', '12:15:56', 1, 3, b'0'),
(614, 44, NULL, 745, '2019-10-07', '12:15:56', 1, 3, b'0'),
(615, 44, NULL, 746, '2019-10-07', '12:15:56', 1, 3, b'0'),
(616, 44, NULL, 747, '2019-10-07', '12:15:56', 1, 3, b'0'),
(617, 44, NULL, 748, '2019-10-07', '12:15:56', 1, 3, b'0'),
(618, 44, NULL, 749, '2019-10-07', '12:15:56', 1, 3, b'0'),
(619, 44, NULL, 750, '2019-10-07', '12:15:56', 1, 3, b'0'),
(620, 44, NULL, 751, '2019-10-07', '12:15:56', 1, 3, b'0'),
(621, 44, NULL, 752, '2019-10-07', '12:15:56', 1, 3, b'0'),
(622, 44, NULL, 753, '2019-10-07', '12:15:56', 1, 3, b'0'),
(623, 3, NULL, 754, '2019-10-07', '05:59:00', 41, 3, b'0'),
(624, 44, NULL, 755, '2019-10-07', '12:15:56', 1, 3, b'0'),
(625, 44, NULL, 756, '2019-10-07', '12:15:56', 1, 3, b'0'),
(626, 44, NULL, 757, '2019-10-07', '12:15:56', 1, 3, b'0'),
(627, 44, NULL, 758, '2019-10-07', '12:15:56', 1, 3, b'0'),
(628, 44, NULL, 759, '2019-10-07', '12:15:56', 1, 3, b'0'),
(629, 44, NULL, 760, '2019-10-07', '12:15:56', 1, 3, b'0'),
(630, 44, NULL, 761, '2019-10-07', '12:15:56', 1, 3, b'0'),
(631, 44, NULL, 762, '2019-10-07', '12:15:56', 1, 3, b'0'),
(632, 44, NULL, 763, '2019-10-07', '12:15:56', 1, 3, b'0'),
(633, 44, NULL, 764, '2019-10-07', '12:15:56', 1, 3, b'0'),
(634, 44, NULL, 765, '2019-10-07', '12:15:56', 1, 3, b'0'),
(635, 44, NULL, 766, '2019-10-07', '12:15:56', 1, 3, b'0'),
(636, 44, NULL, 767, '2019-10-07', '12:15:56', 1, 3, b'0'),
(637, 44, NULL, 768, '2019-10-07', '12:15:56', 1, 3, b'0'),
(638, 44, NULL, 769, '2019-10-07', '12:15:56', 1, 3, b'0'),
(639, 44, NULL, 770, '2019-10-07', '12:15:56', 1, 3, b'0'),
(640, 44, NULL, 771, '2019-10-07', '12:15:56', 1, 3, b'0'),
(641, 44, NULL, 772, '2019-10-07', '12:15:56', 1, 3, b'0'),
(642, 44, NULL, 773, '2019-10-07', '12:15:56', 1, 3, b'0'),
(643, 44, NULL, 774, '2019-10-07', '12:15:56', 1, 3, b'0'),
(644, 44, NULL, 775, '2019-10-07', '12:15:56', 1, 3, b'0'),
(645, 44, NULL, 776, '2019-10-07', '12:15:56', 1, 3, b'0'),
(646, 44, NULL, 777, '2019-10-07', '12:15:56', 1, 3, b'0'),
(647, 44, NULL, 778, '2019-10-07', '12:15:56', 1, 3, b'0'),
(648, 44, NULL, 779, '2019-10-07', '12:15:56', 1, 3, b'0'),
(649, 44, NULL, 780, '2019-10-07', '12:15:56', 1, 3, b'0'),
(650, 44, NULL, 781, '2019-10-07', '12:15:56', 1, 3, b'0'),
(651, 44, NULL, 782, '2019-10-07', '12:15:56', 1, 3, b'0'),
(652, 44, NULL, 783, '2019-10-07', '12:15:56', 1, 3, b'0'),
(653, 44, NULL, 784, '2019-10-07', '12:15:56', 1, 3, b'0'),
(654, 44, NULL, 785, '2019-10-07', '12:15:56', 1, 3, b'0'),
(655, 44, NULL, 786, '2019-10-07', '12:15:56', 1, 3, b'0'),
(656, 44, NULL, 787, '2019-10-07', '12:15:56', 1, 3, b'0'),
(657, 44, NULL, 788, '2019-10-07', '12:15:56', 1, 3, b'0'),
(658, 44, NULL, 789, '2019-10-07', '12:15:56', 1, 3, b'0'),
(659, 44, NULL, 790, '2019-10-07', '12:15:56', 1, 3, b'0'),
(660, 44, NULL, 791, '2019-10-07', '12:15:56', 1, 3, b'0'),
(661, 44, NULL, 792, '2019-10-07', '12:15:56', 1, 3, b'0'),
(662, 44, NULL, 793, '2019-10-07', '12:15:56', 1, 3, b'0'),
(663, 44, NULL, 794, '2019-10-07', '12:15:56', 1, 3, b'0'),
(664, 44, NULL, 795, '2019-10-07', '12:15:56', 1, 3, b'0'),
(665, 44, NULL, 796, '2019-10-07', '12:15:56', 1, 3, b'0'),
(666, 44, NULL, 797, '2019-10-07', '12:15:56', 1, 3, b'0'),
(667, 44, NULL, 798, '2019-10-07', '12:15:56', 1, 3, b'0'),
(668, 44, NULL, 799, '2019-10-07', '12:15:56', 1, 3, b'0'),
(669, 44, NULL, 800, '2019-10-07', '12:15:56', 1, 3, b'0'),
(670, 44, NULL, 801, '2019-10-07', '12:15:56', 1, 3, b'0'),
(671, 44, NULL, 802, '2019-10-07', '12:15:56', 1, 3, b'0'),
(672, 44, NULL, 803, '2019-10-07', '12:15:56', 1, 3, b'0'),
(673, 44, NULL, 804, '2019-10-07', '12:15:56', 1, 3, b'0'),
(674, 44, NULL, 805, '2019-10-07', '12:15:56', 1, 3, b'0'),
(675, 44, NULL, 806, '2019-10-07', '12:15:56', 1, 3, b'0'),
(676, 44, NULL, 807, '2019-10-07', '12:15:56', 1, 3, b'0'),
(677, 44, NULL, 808, '2019-10-07', '12:15:56', 1, 3, b'0'),
(678, 44, NULL, 809, '2019-10-07', '12:15:56', 1, 3, b'0'),
(679, 44, NULL, 810, '2019-10-07', '12:15:56', 1, 3, b'0'),
(680, 44, NULL, 811, '2019-10-07', '12:15:56', 1, 3, b'0'),
(681, 44, NULL, 812, '2019-10-07', '12:15:56', 1, 3, b'0'),
(682, 44, NULL, 813, '2019-10-07', '12:15:56', 1, 3, b'0'),
(683, 44, NULL, 814, '2019-10-07', '12:15:56', 1, 3, b'0'),
(684, 44, NULL, 815, '2019-10-07', '12:15:56', 1, 3, b'0'),
(685, 44, NULL, 816, '2019-10-07', '12:15:56', 1, 3, b'0'),
(686, 44, NULL, 817, '2019-10-07', '12:15:56', 1, 3, b'0'),
(687, 44, NULL, 818, '2019-10-07', '12:15:56', 1, 3, b'0'),
(688, 44, NULL, 819, '2019-10-07', '12:15:56', 1, 3, b'0'),
(689, 44, NULL, 820, '2019-10-07', '12:15:56', 1, 3, b'0'),
(690, 44, NULL, 821, '2019-10-07', '12:15:56', 1, 3, b'0'),
(691, 44, NULL, 822, '2019-10-07', '12:15:56', 1, 3, b'0'),
(692, 44, NULL, 823, '2019-10-07', '12:15:56', 1, 3, b'0'),
(693, 44, NULL, 824, '2019-10-07', '12:15:56', 1, 3, b'0'),
(694, 44, NULL, 825, '2019-10-07', '12:15:56', 1, 3, b'0'),
(695, 44, NULL, 826, '2019-10-07', '12:15:56', 1, 3, b'0'),
(696, 44, NULL, 827, '2019-10-07', '12:15:56', 1, 3, b'0'),
(697, 44, NULL, 828, '2019-10-07', '12:15:56', 1, 3, b'0'),
(698, 44, NULL, 829, '2019-10-07', '12:15:56', 1, 3, b'0'),
(699, 44, NULL, 830, '2019-10-07', '12:15:56', 1, 3, b'0'),
(700, 44, NULL, 831, '2019-10-07', '12:15:56', 1, 3, b'0'),
(701, 44, NULL, 832, '2019-10-07', '12:15:56', 1, 3, b'0'),
(702, 44, NULL, 833, '2019-10-07', '12:15:56', 1, 3, b'0'),
(703, 44, NULL, 834, '2019-10-07', '12:15:56', 1, 3, b'0'),
(704, 44, NULL, 835, '2019-10-07', '12:15:56', 1, 3, b'0'),
(705, 44, NULL, 836, '2019-10-07', '12:15:56', 1, 3, b'0'),
(706, 44, NULL, 837, '2019-10-07', '12:15:56', 1, 3, b'0'),
(707, 44, NULL, 838, '2019-10-07', '12:15:56', 1, 3, b'0'),
(708, 44, NULL, 839, '2019-10-07', '12:15:56', 1, 3, b'0'),
(709, 44, NULL, 840, '2019-10-07', '12:15:56', 1, 3, b'0'),
(710, 44, NULL, 841, '2019-10-07', '12:15:56', 1, 3, b'0'),
(711, 44, NULL, 842, '2019-10-07', '12:15:56', 1, 3, b'0'),
(712, 44, NULL, 843, '2019-10-07', '12:15:56', 1, 3, b'0'),
(713, 44, NULL, 844, '2019-10-07', '12:15:56', 1, 3, b'0'),
(714, 44, NULL, 845, '2019-10-07', '12:15:56', 1, 3, b'0'),
(715, 44, NULL, 846, '2019-10-07', '12:15:56', 1, 3, b'0'),
(716, 44, NULL, 847, '2019-10-07', '12:15:56', 1, 3, b'0'),
(717, 44, NULL, 848, '2019-10-07', '12:15:56', 1, 3, b'0'),
(718, 44, NULL, 849, '2019-10-07', '12:15:56', 1, 3, b'0'),
(719, 44, NULL, 850, '2019-10-07', '12:15:56', 1, 3, b'0'),
(720, 44, NULL, 851, '2019-10-07', '12:15:56', 1, 3, b'0'),
(721, 45, 44, 852, '2019-10-07', '12:42:00', 32, 3, b'0'),
(722, 45, 44, 853, '2019-10-07', '01:01:00', 38, 3, b'0'),
(723, 46, NULL, 854, '2019-10-07', '02:15:00', 41, 3, b'0'),
(724, 46, NULL, 855, '2019-10-07', '02:32:00', 45, 3, b'0'),
(725, 45, 44, 856, '2019-10-07', '12:16:55', 1, 3, b'0'),
(726, 45, 44, 857, '2019-10-07', '12:16:55', 1, 3, b'0'),
(727, 45, 44, 858, '2019-10-07', '12:16:55', 1, 3, b'0'),
(728, 45, 44, 859, '2019-10-07', '12:16:55', 1, 3, b'0'),
(729, 45, 44, 860, '2019-10-07', '12:16:55', 1, 3, b'0'),
(730, 45, 44, 861, '2019-10-07', '12:16:55', 1, 3, b'0'),
(731, 45, 44, 862, '2019-10-07', '12:16:55', 1, 3, b'0'),
(732, 45, 44, 863, '2019-10-07', '12:16:55', 1, 3, b'0'),
(733, 45, 44, 864, '2019-10-07', '12:16:55', 1, 3, b'0'),
(734, 45, 44, 865, '2019-10-07', '12:16:55', 1, 3, b'0'),
(735, 45, 44, 866, '2019-10-07', '12:16:55', 1, 3, b'0'),
(736, 45, 44, 867, '2019-10-07', '12:16:55', 1, 3, b'0'),
(737, 45, 44, 868, '2019-10-07', '12:16:55', 1, 3, b'0'),
(738, 45, 44, 869, '2019-10-07', '12:16:55', 1, 3, b'0'),
(739, 45, 44, 870, '2019-10-07', '12:16:55', 1, 3, b'0'),
(740, 45, 44, 871, '2019-10-07', '12:16:55', 1, 3, b'0'),
(741, 45, 44, 872, '2019-10-07', '12:16:55', 1, 3, b'0'),
(742, 45, 44, 873, '2019-10-07', '12:16:55', 1, 3, b'0'),
(743, 45, 44, 874, '2019-10-07', '12:16:55', 1, 3, b'0'),
(744, 45, 44, 875, '2019-10-07', '12:16:55', 1, 3, b'0'),
(745, 45, 44, 876, '2019-10-07', '12:16:55', 1, 3, b'0'),
(746, 45, 44, 877, '2019-10-07', '12:16:55', 1, 3, b'0'),
(747, 45, 44, 878, '2019-10-07', '12:16:55', 1, 3, b'0'),
(748, 45, 44, 879, '2019-10-07', '12:16:55', 1, 3, b'0'),
(749, 45, 44, 880, '2019-10-07', '12:16:55', 1, 3, b'0'),
(750, 45, 44, 881, '2019-10-07', '12:16:55', 1, 3, b'0'),
(751, 45, 44, 882, '2019-10-07', '12:16:55', 1, 3, b'0'),
(752, 45, 44, 883, '2019-10-07', '12:16:55', 1, 3, b'0'),
(753, 45, 44, 884, '2019-10-07', '12:16:55', 1, 3, b'0'),
(754, 45, 44, 885, '2019-10-07', '12:16:55', 1, 3, b'0'),
(755, 45, 44, 886, '2019-10-07', '12:16:55', 1, 3, b'0'),
(756, 45, 44, 887, '2019-10-07', '12:16:55', 1, 3, b'0'),
(757, 45, 44, 888, '2019-10-07', '12:16:55', 1, 3, b'0'),
(758, 45, 44, 889, '2019-10-07', '12:16:55', 1, 3, b'0'),
(759, 45, 44, 890, '2019-10-07', '12:16:55', 1, 3, b'0'),
(760, 45, 44, 891, '2019-10-07', '12:16:55', 1, 3, b'0'),
(761, 45, 44, 892, '2019-10-07', '12:16:55', 1, 3, b'0'),
(762, 45, 44, 893, '2019-10-07', '12:16:55', 1, 3, b'0'),
(763, 45, 44, 894, '2019-10-07', '12:16:55', 1, 3, b'0'),
(764, 45, 44, 895, '2019-10-07', '12:16:55', 1, 3, b'0'),
(765, 45, 44, 896, '2019-10-07', '12:16:55', 1, 3, b'0'),
(766, 45, 44, 897, '2019-10-07', '12:16:55', 1, 3, b'0'),
(767, 45, 44, 898, '2019-10-07', '12:16:55', 1, 3, b'0'),
(768, 45, 44, 899, '2019-10-07', '12:16:55', 1, 3, b'0'),
(769, 45, 44, 900, '2019-10-07', '12:16:55', 1, 3, b'0'),
(770, 45, 44, 901, '2019-10-07', '12:16:55', 1, 3, b'0'),
(771, 45, 44, 902, '2019-10-07', '12:16:55', 1, 3, b'0'),
(772, 45, 44, 903, '2019-10-07', '12:16:55', 1, 3, b'0'),
(773, 45, 44, 904, '2019-10-07', '12:16:55', 1, 3, b'0'),
(774, 45, 44, 905, '2019-10-07', '12:16:55', 1, 3, b'0'),
(775, 45, 44, 906, '2019-10-07', '12:16:55', 1, 3, b'0'),
(776, 45, 44, 907, '2019-10-07', '12:16:55', 1, 3, b'0'),
(777, 45, 44, 908, '2019-10-07', '12:16:55', 1, 3, b'0'),
(778, 45, 44, 909, '2019-10-07', '12:16:55', 1, 3, b'0'),
(779, 45, 44, 910, '2019-10-07', '12:16:55', 1, 3, b'0'),
(780, 45, 44, 911, '2019-10-07', '12:16:55', 1, 3, b'0'),
(781, 45, 44, 912, '2019-10-07', '12:16:55', 1, 3, b'0'),
(782, 45, 44, 913, '2019-10-07', '12:16:55', 1, 3, b'0'),
(783, 45, 44, 914, '2019-10-07', '12:16:55', 1, 3, b'0'),
(784, 45, 44, 915, '2019-10-07', '12:16:55', 1, 3, b'0'),
(785, 45, 44, 916, '2019-10-07', '12:16:55', 1, 3, b'0'),
(786, 45, 44, 917, '2019-10-07', '12:16:55', 1, 3, b'0'),
(787, 45, 44, 918, '2019-10-07', '12:16:55', 1, 3, b'0'),
(788, 45, 44, 919, '2019-10-07', '12:16:55', 1, 3, b'0'),
(789, 45, 44, 920, '2019-10-07', '12:16:55', 1, 3, b'0'),
(790, 45, 44, 921, '2019-10-07', '12:16:55', 1, 3, b'0'),
(791, 45, 44, 922, '2019-10-07', '12:16:55', 1, 3, b'0'),
(792, 45, 44, 923, '2019-10-07', '12:16:55', 1, 3, b'0'),
(793, 45, 44, 924, '2019-10-07', '12:16:55', 1, 3, b'0'),
(794, 45, 44, 925, '2019-10-07', '12:16:55', 1, 3, b'0'),
(795, 45, 44, 926, '2019-10-07', '12:16:55', 1, 3, b'0'),
(796, 45, 44, 927, '2019-10-07', '12:16:55', 1, 3, b'0'),
(797, 45, 44, 928, '2019-10-07', '12:16:55', 1, 3, b'0'),
(798, 45, 44, 929, '2019-10-07', '12:16:55', 1, 3, b'0'),
(799, 45, 44, 930, '2019-10-07', '12:46:00', 36, 3, b'0'),
(800, 45, 44, 931, '2019-10-07', '12:16:55', 1, 3, b'0'),
(801, 45, 44, 932, '2019-10-07', '12:16:55', 1, 3, b'0'),
(802, 45, 44, 933, '2019-10-07', '12:16:55', 1, 3, b'0'),
(803, 45, 44, 934, '2019-10-07', '12:16:55', 1, 3, b'0'),
(804, 45, 44, 935, '2019-10-07', '12:16:55', 1, 3, b'0'),
(805, 45, 44, 936, '2019-10-07', '12:16:55', 1, 3, b'0'),
(806, 45, 44, 937, '2019-10-07', '12:16:55', 1, 3, b'0'),
(807, 45, 44, 938, '2019-10-07', '12:16:55', 1, 3, b'0'),
(808, 45, 44, 939, '2019-10-07', '12:16:55', 1, 3, b'0'),
(809, 45, 44, 940, '2019-10-07', '12:57:00', 35, 3, b'0'),
(810, 45, 44, 941, '2019-10-07', '05:06:00', 31, 3, b'0'),
(811, 45, 44, 942, '2019-10-07', '12:45:00', 27, 3, b'0'),
(812, 45, 44, 943, '2019-10-07', '12:45:00', 29, 3, b'0'),
(813, 45, 44, 944, '2019-10-07', '12:58:00', 39, 3, b'0'),
(814, 45, 44, 945, '2019-10-07', '12:58:00', 31, 3, b'0'),
(815, 45, 44, 946, '2019-10-07', '12:59:00', 38, 3, b'0'),
(816, 45, 44, 947, '2019-10-07', '05:19:00', 21, 3, b'0'),
(817, 45, 44, 948, '2019-10-07', '12:59:00', 29, 3, b'0'),
(818, 45, 44, 949, '2019-10-07', '01:00:00', 39, 3, b'0'),
(819, 45, 44, 950, '2019-10-07', '01:00:00', 26, 3, b'0'),
(820, 45, 44, 951, '2019-10-07', '01:01:00', 29, 3, b'0'),
(821, 46, NULL, 952, '2019-10-07', '12:19:42', 1, 3, b'0'),
(822, 46, NULL, 953, '2019-10-07', '12:19:42', 1, 3, b'0'),
(823, 46, NULL, 954, '2019-10-07', '12:19:42', 1, 3, b'0'),
(824, 46, NULL, 955, '2019-10-07', '12:19:42', 1, 3, b'0'),
(825, 46, NULL, 956, '2019-10-07', '12:19:42', 1, 3, b'0'),
(826, 46, NULL, 957, '2019-10-07', '12:19:42', 1, 3, b'0'),
(827, 46, NULL, 958, '2019-10-07', '12:19:42', 1, 3, b'0'),
(828, 46, NULL, 959, '2019-10-07', '12:19:42', 1, 3, b'0'),
(829, 46, NULL, 960, '2019-10-07', '12:19:42', 1, 3, b'0'),
(830, 46, NULL, 961, '2019-10-07', '12:19:42', 1, 3, b'0'),
(831, 46, NULL, 962, '2019-10-07', '12:19:42', 1, 3, b'0'),
(832, 46, NULL, 963, '2019-10-07', '12:19:42', 1, 3, b'0'),
(833, 46, NULL, 964, '2019-10-07', '12:19:42', 1, 3, b'0'),
(834, 46, NULL, 965, '2019-10-07', '12:19:42', 1, 3, b'0'),
(835, 46, NULL, 966, '2019-10-07', '12:19:42', 1, 3, b'0'),
(836, 46, NULL, 967, '2019-10-07', '12:19:42', 1, 3, b'0'),
(837, 46, NULL, 968, '2019-10-07', '12:19:42', 1, 3, b'0'),
(838, 46, NULL, 969, '2019-10-07', '12:19:42', 1, 3, b'0'),
(839, 46, NULL, 970, '2019-10-07', '12:19:42', 1, 3, b'0'),
(840, 46, NULL, 971, '2019-10-07', '12:19:42', 1, 3, b'0'),
(841, 46, NULL, 972, '2019-10-07', '12:19:42', 1, 3, b'0'),
(842, 46, NULL, 973, '2019-10-07', '12:19:42', 1, 3, b'0'),
(843, 46, NULL, 974, '2019-10-07', '12:19:42', 1, 3, b'0'),
(844, 46, NULL, 975, '2019-10-07', '12:19:42', 1, 3, b'0'),
(845, 46, NULL, 976, '2019-10-07', '12:19:42', 1, 3, b'0'),
(846, 46, NULL, 977, '2019-10-07', '12:19:42', 1, 3, b'0'),
(847, 46, NULL, 978, '2019-10-07', '12:19:42', 1, 3, b'0'),
(848, 46, NULL, 979, '2019-10-07', '12:19:42', 1, 3, b'0'),
(849, 46, NULL, 980, '2019-10-07', '12:19:42', 1, 3, b'0'),
(850, 46, NULL, 981, '2019-10-07', '12:19:42', 1, 3, b'0'),
(851, 46, NULL, 982, '2019-10-07', '12:19:42', 1, 3, b'0'),
(852, 46, NULL, 983, '2019-10-07', '12:19:42', 1, 3, b'0'),
(853, 46, NULL, 984, '2019-10-07', '12:19:42', 1, 3, b'0'),
(854, 46, NULL, 985, '2019-10-07', '12:19:42', 1, 3, b'0'),
(855, 46, NULL, 986, '2019-10-07', '12:19:42', 1, 3, b'0'),
(856, 46, NULL, 987, '2019-10-07', '12:19:42', 1, 3, b'0'),
(857, 46, NULL, 988, '2019-10-07', '12:19:42', 1, 3, b'0'),
(858, 46, NULL, 989, '2019-10-07', '12:19:42', 1, 3, b'0'),
(859, 46, NULL, 990, '2019-10-07', '12:19:42', 1, 3, b'0'),
(860, 46, NULL, 991, '2019-10-07', '12:19:42', 1, 3, b'0'),
(861, 46, NULL, 992, '2019-10-07', '12:19:42', 1, 3, b'0'),
(862, 46, NULL, 993, '2019-10-07', '12:19:42', 1, 3, b'0'),
(863, 46, NULL, 994, '2019-10-07', '12:19:42', 1, 3, b'0'),
(864, 46, NULL, 995, '2019-10-07', '12:19:42', 1, 3, b'0'),
(865, 46, NULL, 996, '2019-10-07', '12:19:42', 1, 3, b'0'),
(866, 46, NULL, 997, '2019-10-07', '12:19:42', 1, 3, b'0'),
(867, 46, NULL, 998, '2019-10-07', '12:19:42', 1, 3, b'0'),
(868, 46, NULL, 999, '2019-10-07', '12:19:42', 1, 3, b'0'),
(869, 46, NULL, 1000, '2019-10-07', '12:19:42', 1, 3, b'0'),
(870, 46, NULL, 1001, '2019-10-07', '12:19:42', 1, 3, b'0'),
(871, 46, NULL, 1002, '2019-10-07', '12:19:42', 1, 3, b'0'),
(872, 46, NULL, 1003, '2019-10-07', '12:19:42', 1, 3, b'0'),
(873, 46, NULL, 1004, '2019-10-07', '12:19:42', 1, 3, b'0'),
(874, 46, NULL, 1005, '2019-10-07', '12:19:42', 1, 3, b'0'),
(875, 46, NULL, 1006, '2019-10-07', '12:19:42', 1, 3, b'0'),
(876, 46, NULL, 1007, '2019-10-07', '12:19:42', 1, 3, b'0'),
(877, 46, NULL, 1008, '2019-10-07', '12:19:42', 1, 3, b'0'),
(878, 46, NULL, 1009, '2019-10-07', '12:19:42', 1, 3, b'0'),
(879, 46, NULL, 1010, '2019-10-07', '12:19:42', 1, 3, b'0'),
(880, 46, NULL, 1011, '2019-10-07', '12:19:42', 1, 3, b'0'),
(881, 46, NULL, 1012, '2019-10-07', '12:19:42', 1, 3, b'0'),
(882, 46, NULL, 1013, '2019-10-07', '12:19:42', 1, 3, b'0'),
(883, 46, NULL, 1014, '2019-10-07', '12:19:42', 1, 3, b'0'),
(884, 46, NULL, 1015, '2019-10-07', '12:19:42', 1, 3, b'0'),
(885, 46, NULL, 1016, '2019-10-07', '12:19:42', 1, 3, b'0'),
(886, 46, NULL, 1017, '2019-10-07', '12:19:42', 1, 3, b'0'),
(887, 46, NULL, 1018, '2019-10-07', '12:19:42', 1, 3, b'0'),
(888, 46, NULL, 1019, '2019-10-07', '12:19:42', 1, 3, b'0'),
(889, 46, NULL, 1020, '2019-10-07', '12:19:42', 1, 3, b'0'),
(890, 46, NULL, 1021, '2019-10-07', '12:19:42', 1, 3, b'0'),
(891, 46, NULL, 1022, '2019-10-07', '12:19:42', 1, 3, b'0'),
(892, 46, NULL, 1023, '2019-10-07', '12:19:42', 1, 3, b'0'),
(893, 46, NULL, 1024, '2019-10-07', '12:19:42', 1, 3, b'0'),
(894, 46, NULL, 1025, '2019-10-07', '12:19:42', 1, 3, b'0'),
(895, 46, NULL, 1026, '2019-10-07', '12:19:42', 1, 3, b'0'),
(896, 46, NULL, 1027, '2019-10-07', '12:19:42', 1, 3, b'0'),
(897, 46, NULL, 1028, '2019-10-07', '12:19:42', 1, 3, b'0'),
(898, 46, NULL, 1029, '2019-10-07', '12:19:42', 1, 3, b'0'),
(899, 46, NULL, 1030, '2019-10-07', '12:19:42', 1, 3, b'0'),
(900, 46, NULL, 1031, '2019-10-07', '12:19:42', 1, 3, b'0'),
(901, 46, NULL, 1032, '2019-10-07', '12:19:42', 1, 3, b'0'),
(902, 46, NULL, 1033, '2019-10-07', '12:19:42', 1, 3, b'0'),
(903, 46, NULL, 1034, '2019-10-07', '12:19:42', 1, 3, b'0'),
(904, 46, NULL, 1035, '2019-10-07', '12:19:42', 1, 3, b'0'),
(905, 46, NULL, 1036, '2019-10-07', '12:19:42', 1, 3, b'0'),
(906, 46, NULL, 1037, '2019-10-07', '12:19:42', 1, 3, b'0'),
(907, 46, NULL, 1038, '2019-10-07', '12:19:42', 1, 3, b'0'),
(908, 46, NULL, 1039, '2019-10-07', '12:19:42', 1, 3, b'0'),
(909, 46, NULL, 1040, '2019-10-07', '12:19:42', 1, 3, b'0'),
(910, 46, NULL, 1041, '2019-10-07', '12:19:42', 1, 3, b'0'),
(911, 46, NULL, 1042, '2019-10-07', '12:19:42', 1, 3, b'0'),
(912, 46, NULL, 1043, '2019-10-07', '12:19:42', 1, 3, b'0'),
(913, 46, NULL, 1044, '2019-10-07', '12:19:42', 1, 3, b'0'),
(914, 46, NULL, 1045, '2019-10-07', '12:19:42', 1, 3, b'0'),
(915, 46, NULL, 1046, '2019-10-07', '12:19:42', 1, 3, b'0'),
(916, 46, NULL, 1047, '2019-10-07', '12:19:42', 1, 3, b'0'),
(917, 46, NULL, 1048, '2019-10-07', '12:19:42', 1, 3, b'0'),
(918, 46, NULL, 1049, '2019-10-07', '12:19:42', 1, 3, b'0'),
(919, 46, NULL, 1050, '2019-10-07', '12:19:42', 1, 3, b'0'),
(920, 46, NULL, 1051, '2019-10-07', '12:19:42', 1, 3, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `mailattachs`
--

CREATE TABLE `mailattachs` (
  `ID` int(11) NOT NULL,
  `MailID` int(11) NOT NULL,
  `FileName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mailattachs`
--

INSERT INTO `mailattachs` (`ID`, `MailID`, `FileName`) VALUES
(28, 51, 'File_07-10-201915704567960.pdf'),
(29, 52, 'File_07-10-201915704582350.png'),
(30, 54, 'File_07-10-201915704594130.jpg'),
(31, 55, 'File_07-10-201915704596020.pdf'),
(32, 56, 'File_07-10-201915704602990.png'),
(33, 56, 'File_07-10-201915704602991.pdf'),
(34, 57, 'File_07-10-201915704603680.png'),
(35, 57, 'File_07-10-201915704603681.pdf'),
(36, 58, 'File_07-10-201915704605950.png'),
(37, 58, 'File_07-10-201915704605951.pdf'),
(38, 59, 'File_07-10-201915704606990.png'),
(39, 59, 'File_07-10-201915704606991.pdf'),
(40, 61, 'File_07-10-201915704626590.png'),
(41, 61, 'File_07-10-201915704626591.pdf'),
(42, 62, 'File_07-10-201915704641520.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `messagecrm`
--

CREATE TABLE `messagecrm` (
  `CrmMessagesId` int(11) NOT NULL,
  `CrmMessagesFrom` int(11) NOT NULL,
  `CrmMessagesTo` int(11) NOT NULL DEFAULT '0',
  `CrmMessagesCustomer` int(11) NOT NULL DEFAULT '0',
  `CrmMessagesTitle` varchar(255) NOT NULL,
  `CrmMessagesContent` varchar(1000) NOT NULL,
  `CrmMessagesType` int(1) NOT NULL COMMENT 'لو بواحد تبقي رسائل لو ب 2 تبقي ايميل لو ب 3 تبقي تعليمات لو ب 4 تبقي شكاوي',
  `CrmMessagesCreateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CrmMessagesUpdateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `subjectid` int(11) NOT NULL,
  `complain` int(1) NOT NULL DEFAULT '1' COMMENT 'لو بواحد تبقي خاصه بعميل لو ب 2 تبقي خاصه بموظف',
  `active` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `my_calender`
--

CREATE TABLE `my_calender` (
  `calender_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fayfrom` datetime NOT NULL,
  `dayto` datetime NOT NULL,
  `Notes` varchar(250) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `color` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `paymenttypes`
--

CREATE TABLE `paymenttypes` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `paymenttypes`
--

INSERT INTO `paymenttypes` (`ID`, `Name`) VALUES
(7, 'الدفع عند الإستلام'),
(8, 'تحويل بنكى'),
(9, 'فودافون كاش');

-- --------------------------------------------------------

--
-- Table structure for table `permissioncrm`
--

CREATE TABLE `permissioncrm` (
  `permissioncrmId` int(11) NOT NULL,
  `permissionuser` int(11) NOT NULL,
  `permissionid` int(11) NOT NULL COMMENT 'لو 1 يبقي تنبيهات الكل لو 2 يبقي الموافقه ع الرساائل لو 3 يبقي رفع ملف المهام لو 4 يبقي تعين المهام لو 5 يبقي صفحه الموظفين لو 66 يبقي صفحه المشرفين لو 7 يبقي استقبال الشكاوي لو 8 يبقي ارسال تعليممات للكل لو 9 يبقي المنتجات وطرق الشحن لو 10 يبقي تحميل قاعده البيناتات لو 11 يبقي التقارير الكامله لو 12 12 يبقي تعديل الوحه التحكم لو 133 يبقي بينانات الشركه'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissioncrm`
--

INSERT INTO `permissioncrm` (`permissioncrmId`, `permissionuser`, `permissionid`) VALUES
(9, 62, 3),
(10, 62, 4),
(20, 61, 3),
(21, 61, 9),
(22, 61, 10),
(23, 63, 1),
(24, 63, 2),
(25, 63, 3),
(26, 63, 4),
(27, 63, 5),
(28, 63, 6),
(29, 63, 7),
(30, 63, 8),
(31, 63, 9),
(32, 63, 10),
(33, 63, 11),
(34, 63, 12),
(35, 63, 13),
(39, 65, 1),
(40, 65, 2),
(41, 65, 7),
(42, 65, 8),
(43, 65, 11),
(44, 64, 1),
(45, 64, 2),
(46, 64, 3),
(47, 64, 4),
(68, 66, 1),
(69, 66, 2),
(70, 66, 7),
(71, 66, 11),
(72, 66, 1);

-- --------------------------------------------------------

--
-- Table structure for table `productcrm`
--

CREATE TABLE `productcrm` (
  `ProductCrmId` int(11) NOT NULL,
  `ProductCrmName` varchar(255) NOT NULL,
  `ProductCrmPrice` int(11) NOT NULL,
  `ProductCrmDesc` varchar(500) NOT NULL,
  `ProductCrmCancelDate` int(11) NOT NULL,
  `ProductCrmType` int(11) NOT NULL COMMENT 'لو ب 1 يبقي منتج لو ب 2 يبقي خدمه لو ب 3 يبقي طريقه شحن',
  `ProductCrmCreateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ProductCrmUpdateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settingcrm`
--

CREATE TABLE `settingcrm` (
  `settingcrmId` int(11) NOT NULL,
  `settingcrmTimeMinute` int(11) NOT NULL,
  `settimgcrmType` int(11) NOT NULL,
  `settingcrmName` varchar(255) NOT NULL,
  `settingcrmPhone` varchar(255) NOT NULL,
  `settingcrmFax` varchar(255) NOT NULL,
  `settingcrmEmail` varchar(255) NOT NULL,
  `settingcrmAddress` varchar(255) NOT NULL,
  `settingcrmSite` varchar(255) NOT NULL,
  `settingcrmCreateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `settingcrmUpdateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `settingcrmLogo` varchar(255) NOT NULL,
  `loginbg` varchar(255) DEFAULT NULL,
  `notifyTime` int(11) NOT NULL DEFAULT '30'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settingcrm`
--

INSERT INTO `settingcrm` (`settingcrmId`, `settingcrmTimeMinute`, `settimgcrmType`, `settingcrmName`, `settingcrmPhone`, `settingcrmFax`, `settingcrmEmail`, `settingcrmAddress`, `settingcrmSite`, `settingcrmCreateDate`, `settingcrmUpdateDate`, `settingcrmLogo`, `loginbg`, `notifyTime`) VALUES
(1, 30, 0, 'CRM', '01098015152', '333', 'CRM@gmail.com', '4 St', 'www.crm.com', '2018-03-12 11:32:14', '2018-03-12 11:32:14', '1568817652.png', 'loginbg3.jpeg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `smsconfiguration`
--

CREATE TABLE `smsconfiguration` (
  `ID` int(11) NOT NULL,
  `BaseURL` varchar(255) NOT NULL,
  `UserID` varchar(255) NOT NULL,
  `UserPassword` varchar(255) NOT NULL,
  `SenderName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `smsconfiguration`
--

INSERT INTO `smsconfiguration` (`ID`, `BaseURL`, `UserID`, `UserPassword`, `SenderName`) VALUES
(1, 'http://tekegy.org', 'ElFarouke', 'ElFarouke123', 'Gate');

-- --------------------------------------------------------

--
-- Table structure for table `smtp_configuration`
--

CREATE TABLE `smtp_configuration` (
  `ID` int(11) NOT NULL,
  `Emp_ID` int(11) NOT NULL,
  `Mail_Address` text NOT NULL,
  `Mail_Password` text NOT NULL,
  `Mail_Server` text NOT NULL,
  `Port` varchar(10) NOT NULL DEFAULT '587'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `smtp_configuration`
--

INSERT INTO `smtp_configuration` (`ID`, `Emp_ID`, `Mail_Address`, `Mail_Password`, `Mail_Server`, `Port`) VALUES
(17, 44, '', '123', '', '587'),
(18, 45, '', '123', '', '587'),
(19, 46, '', '123', '', '587'),
(20, 47, '', '', '', '587');

-- --------------------------------------------------------

--
-- Table structure for table `statuscrm`
--

CREATE TABLE `statuscrm` (
  `statusCrmId` int(11) NOT NULL,
  `statusCrmContent` varchar(1000) NOT NULL,
  `statusCrmfilter` int(11) NOT NULL DEFAULT '0' COMMENT 'متابعه ولا قيد الحجز ولا قفل ولا شراء',
  `statusCrmType` int(11) NOT NULL DEFAULT '0' COMMENT 'تم الرد او لم يتم الرد',
  `statusCrmCreateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statusCrmUpdateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `at_home` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=>false,1=>true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `statuscrm`
--

INSERT INTO `statuscrm` (`statusCrmId`, `statusCrmContent`, `statusCrmfilter`, `statusCrmType`, `statusCrmCreateDate`, `statusCrmUpdateDate`, `at_home`) VALUES
(0, 'حاله جديده', 0, 0, '2018-04-11 15:41:10', '2018-04-11 15:41:10', 0),
(1, 'متابعه', 1, 1, '2018-03-25 19:33:23', '2018-03-25 19:33:23', 0),
(2, 'إلغاء المتابعة', 3, 2, '2018-03-25 19:33:23', '2018-03-25 19:33:23', 0),
(3, 'سيتواصل', 1, 1, '2018-03-25 19:33:23', '2018-03-25 19:33:23', 0),
(4, 'انقطاع الاتصال', 1, 1, '2018-03-25 19:33:23', '2018-03-25 19:33:23', 0),
(5, 'رقم خطأ', 3, 2, '2018-03-25 19:33:23', '2018-03-25 19:33:23', 0),
(6, 'شحن', 2, 1, '2018-03-25 19:36:14', '2018-03-25 19:36:14', 0),
(7, 'زياره', 2, 1, '2018-03-25 19:36:14', '2018-03-25 19:36:14', 0),
(8, 'شراء', 4, 1, '2018-03-25 19:36:14', '2018-03-25 19:36:14', 0),
(9, 'حجز', 2, 1, '2018-03-25 19:36:14', '2018-03-25 19:36:14', 0),
(10, 'موعد تحويل', 2, 1, '2018-03-25 19:36:14', '2018-03-25 19:36:14', 0),
(11, 'مشغول', 1, 2, '2018-03-25 19:40:13', '2018-03-25 19:40:13', 0),
(12, 'مغلق', 1, 2, '2018-03-25 19:40:13', '2018-03-25 19:40:13', 0),
(13, 'غير متاح', 1, 2, '2018-03-25 19:40:13', '2018-03-25 19:40:13', 0),
(14, 'غير موجود بالخدمه', 3, 2, '2018-03-25 19:40:13', '2018-03-25 19:40:13', 0),
(19, 'حاله جديده في تم الرد', 1, 1, '2018-03-25 20:17:17', '2018-03-25 20:17:17', 0),
(20, 'حاله تبع قيد الحجز', 2, 1, '2018-03-25 20:19:26', '2018-03-25 20:19:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `createat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updateat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usercrm`
--

CREATE TABLE `usercrm` (
  `userCrmId` int(11) NOT NULL,
  `userCrmName` varchar(255) NOT NULL,
  `userCrmEmail` varchar(255) NOT NULL,
  `userCrmPass` varchar(500) NOT NULL,
  `userCrmPhone` varchar(255) NOT NULL,
  `userCrmAddress` varchar(255) NOT NULL,
  `userCrmGender` varchar(255) NOT NULL,
  `userCrmBirthDate` date NOT NULL,
  `userCrmSalary` int(11) NOT NULL,
  `userCrmAnnInc` int(11) NOT NULL,
  `userCrmSellInc` int(11) NOT NULL,
  `userCrmJoinDate` date NOT NULL,
  `userCrmType` int(1) NOT NULL,
  `userCrmSuper` int(11) NOT NULL,
  `userCrmUserName` varchar(255) NOT NULL,
  `userCrmCreateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userCrmUpdateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usercrmGroup` int(11) NOT NULL,
  `usercrmStatus` int(1) NOT NULL DEFAULT '3',
  `active` int(1) NOT NULL DEFAULT '1',
  `num_message` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_call_status`
--

CREATE TABLE `user_call_status` (
  `id` int(11) NOT NULL,
  `Status_Name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_call_status`
--

INSERT INTO `user_call_status` (`id`, `Status_Name`) VALUES
(1, 'فعال'),
(2, 'غير فعال'),
(3, 'فى مكالمة');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Login_Time` datetime DEFAULT NULL,
  `Last_Seen` datetime DEFAULT NULL,
  `Status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_messages`
--

CREATE TABLE `user_messages` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `Delayed_Calls` int(11) NOT NULL DEFAULT '0',
  `UpcommingCalls` int(11) NOT NULL DEFAULT '0',
  `UpcommingCalls_Seen` bit(1) NOT NULL DEFAULT b'0',
  `Delayed_Calls_Seen` bit(1) NOT NULL DEFAULT b'0',
  `Delayed_ForAdmin` int(11) NOT NULL DEFAULT '0',
  `Delayed_ForSupervisor` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_messages`
--

INSERT INTO `user_messages` (`id`, `userID`, `Delayed_Calls`, `UpcommingCalls`, `UpcommingCalls_Seen`, `Delayed_Calls_Seen`, `Delayed_ForAdmin`, `Delayed_ForSupervisor`) VALUES
(3, 3, 0, 0, b'0', b'0', 1, 0),
(4, 33, 0, 0, b'0', b'0', 5, 0),
(5, 32, 0, 0, b'0', b'0', 5, 0),
(6, 36, 0, 0, b'0', b'0', 1, 0),
(7, 39, 0, 0, b'0', b'0', 5, 0),
(8, 40, 0, 0, b'0', b'0', 0, 0),
(9, 45, 0, 0, b'0', b'0', 4, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calendercrm`
--
ALTER TABLE `calendercrm`
  ADD PRIMARY KEY (`CalenderCrmId`);

--
-- Indexes for table `call_status`
--
ALTER TABLE `call_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `call_status2`
--
ALTER TABLE `call_status2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Sattus_Parent` (`Status_Parent`);

--
-- Indexes for table `changecrm`
--
ALTER TABLE `changecrm`
  ADD PRIMARY KEY (`changecrmID`);

--
-- Indexes for table `client_notes`
--
ALTER TABLE `client_notes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ClientID` (`ClientID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `client_orders`
--
ALTER TABLE `client_orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Client_ID` (`Client_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `client_orders_details`
--
ALTER TABLE `client_orders_details`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Order_ID` (`Order_ID`),
  ADD KEY `Payment_ID` (`Payment_ID`),
  ADD KEY `Transfer_ID` (`Transfer_ID`),
  ADD KEY `Unit_ID` (`Unit_ID`);

--
-- Indexes for table `client_payments`
--
ALTER TABLE `client_payments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Client_ID` (`Client_ID`),
  ADD KEY `Order_ID` (`Order_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `communication_settings`
--
ALTER TABLE `communication_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `Client_ID` (`Client_ID`),
  ADD KEY `To_User` (`To_User`);

--
-- Indexes for table `complaints_details`
--
ALTER TABLE `complaints_details`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `complaints_details_ibfk_1` (`complaints_ID`),
  ADD KEY `Owner_ID` (`Owner_ID`);

--
-- Indexes for table `crm_calls`
--
ALTER TABLE `crm_calls`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `crm_calls_ibfk_1` (`ClientID`),
  ADD KEY `call_Result` (`call_Result`),
  ADD KEY `crm_calls_ibfk_4` (`CommentID`);

--
-- Indexes for table `crm_call_notifications`
--
ALTER TABLE `crm_call_notifications`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FollowID` (`FollowID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `crm_comments`
--
ALTER TABLE `crm_comments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ClientID` (`ClientID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `FollowID` (`FollowID`);

--
-- Indexes for table `crm_empnotifications`
--
ALTER TABLE `crm_empnotifications`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `crm_follows`
--
ALTER TABLE `crm_follows`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `crm_follows_ibfk_1` (`UserID`),
  ADD KEY `crm_follows_ibfk_2` (`ClientID`);

--
-- Indexes for table `crm_internal_messages`
--
ALTER TABLE `crm_internal_messages`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Client_ID` (`Client_ID`),
  ADD KEY `From_User` (`From_User`),
  ADD KEY `To_User` (`To_User`),
  ADD KEY `Message_Type` (`Message_Type`),
  ADD KEY `OnerUserID` (`ownerUserID`);

--
-- Indexes for table `crm_internal_messages_types`
--
ALTER TABLE `crm_internal_messages_types`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `crm_mails`
--
ALTER TABLE `crm_mails`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ClientID` (`ClientID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `crm_messages`
--
ALTER TABLE `crm_messages`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `From_User` (`UserID`);

--
-- Indexes for table `crm_messages_details`
--
ALTER TABLE `crm_messages_details`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Owner_ID` (`Owner_ID`),
  ADD KEY `crm_messages_details_ibfk_1` (`Message_ID`);

--
-- Indexes for table `crm_messages_users`
--
ALTER TABLE `crm_messages_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `MessageID` (`MessageID`);

--
-- Indexes for table `crm_notifications`
--
ALTER TABLE `crm_notifications`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `crm_orders`
--
ALTER TABLE `crm_orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ClientID` (`ClientID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `transfer_id` (`transfer_id`);

--
-- Indexes for table `crm_ordersettings`
--
ALTER TABLE `crm_ordersettings`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `parent` (`parent`);

--
-- Indexes for table `crm_permissions_objects`
--
ALTER TABLE `crm_permissions_objects`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Code` (`Code`);

--
-- Indexes for table `crm_products`
--
ALTER TABLE `crm_products`
  ADD PRIMARY KEY (`Product_ID`);

--
-- Indexes for table `crm_sms`
--
ALTER TABLE `crm_sms`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ClientID` (`ClientID`);

--
-- Indexes for table `crm_transfer_type`
--
ALTER TABLE `crm_transfer_type`
  ADD PRIMARY KEY (`transfer_ID`);

--
-- Indexes for table `crm_users`
--
ALTER TABLE `crm_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Super` (`Super`),
  ADD KEY `Type` (`Type`);

--
-- Indexes for table `crm_userstypes`
--
ALTER TABLE `crm_userstypes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `crm_users_log`
--
ALTER TABLE `crm_users_log`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `Status` (`Status`);

--
-- Indexes for table `crm_users_permissions`
--
ALTER TABLE `crm_users_permissions`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `Object_Code` (`Object_Code`);

--
-- Indexes for table `customercrm`
--
ALTER TABLE `customercrm`
  ADD PRIMARY KEY (`customerCrmId`),
  ADD KEY `addedby` (`addedby`);

--
-- Indexes for table `customerproductcrm`
--
ALTER TABLE `customerproductcrm`
  ADD PRIMARY KEY (`customerProductId`);

--
-- Indexes for table `employees_tasks`
--
ALTER TABLE `employees_tasks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientID` (`clientID`),
  ADD KEY `employees_tasks_ibfk_1` (`clientID`),
  ADD KEY `employees_tasks_ibfk_2` (`userID`),
  ADD KEY `Status` (`Status`),
  ADD KEY `supervisor_ID` (`supervisor_ID`),
  ADD KEY `Distributor_By` (`Distributor_By`);

--
-- Indexes for table `mailattachs`
--
ALTER TABLE `mailattachs`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `MailID` (`MailID`);

--
-- Indexes for table `messagecrm`
--
ALTER TABLE `messagecrm`
  ADD PRIMARY KEY (`CrmMessagesId`);

--
-- Indexes for table `my_calender`
--
ALTER TABLE `my_calender`
  ADD PRIMARY KEY (`calender_id`),
  ADD KEY `user_calender_id` (`user_id`);

--
-- Indexes for table `paymenttypes`
--
ALTER TABLE `paymenttypes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `permissioncrm`
--
ALTER TABLE `permissioncrm`
  ADD PRIMARY KEY (`permissioncrmId`);

--
-- Indexes for table `productcrm`
--
ALTER TABLE `productcrm`
  ADD PRIMARY KEY (`ProductCrmId`);

--
-- Indexes for table `settingcrm`
--
ALTER TABLE `settingcrm`
  ADD PRIMARY KEY (`settingcrmId`);

--
-- Indexes for table `smsconfiguration`
--
ALTER TABLE `smsconfiguration`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `smtp_configuration`
--
ALTER TABLE `smtp_configuration`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Emp_ID` (`Emp_ID`);

--
-- Indexes for table `statuscrm`
--
ALTER TABLE `statuscrm`
  ADD PRIMARY KEY (`statusCrmId`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usercrm`
--
ALTER TABLE `usercrm`
  ADD PRIMARY KEY (`userCrmId`);

--
-- Indexes for table `user_call_status`
--
ALTER TABLE `user_call_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Status` (`Status`),
  ADD KEY `user_log_ibfk_1` (`UserID`);

--
-- Indexes for table `user_messages`
--
ALTER TABLE `user_messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `calendercrm`
--
ALTER TABLE `calendercrm`
  MODIFY `CalenderCrmId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `call_status`
--
ALTER TABLE `call_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `call_status2`
--
ALTER TABLE `call_status2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `changecrm`
--
ALTER TABLE `changecrm`
  MODIFY `changecrmID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `client_notes`
--
ALTER TABLE `client_notes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_orders`
--
ALTER TABLE `client_orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `client_orders_details`
--
ALTER TABLE `client_orders_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `client_payments`
--
ALTER TABLE `client_payments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `communication_settings`
--
ALTER TABLE `communication_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `complaints_details`
--
ALTER TABLE `complaints_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `crm_calls`
--
ALTER TABLE `crm_calls`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `crm_call_notifications`
--
ALTER TABLE `crm_call_notifications`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `crm_comments`
--
ALTER TABLE `crm_comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `crm_follows`
--
ALTER TABLE `crm_follows`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `crm_internal_messages`
--
ALTER TABLE `crm_internal_messages`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_internal_messages_types`
--
ALTER TABLE `crm_internal_messages_types`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `crm_mails`
--
ALTER TABLE `crm_mails`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `crm_messages`
--
ALTER TABLE `crm_messages`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `crm_messages_details`
--
ALTER TABLE `crm_messages_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `crm_messages_users`
--
ALTER TABLE `crm_messages_users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `crm_notifications`
--
ALTER TABLE `crm_notifications`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_orders`
--
ALTER TABLE `crm_orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_ordersettings`
--
ALTER TABLE `crm_ordersettings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `crm_permissions_objects`
--
ALTER TABLE `crm_permissions_objects`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `crm_products`
--
ALTER TABLE `crm_products`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `crm_sms`
--
ALTER TABLE `crm_sms`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `crm_transfer_type`
--
ALTER TABLE `crm_transfer_type`
  MODIFY `transfer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `crm_users`
--
ALTER TABLE `crm_users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `crm_userstypes`
--
ALTER TABLE `crm_userstypes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `crm_users_log`
--
ALTER TABLE `crm_users_log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `crm_users_permissions`
--
ALTER TABLE `crm_users_permissions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=605;

--
-- AUTO_INCREMENT for table `customercrm`
--
ALTER TABLE `customercrm`
  MODIFY `customerCrmId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1284;

--
-- AUTO_INCREMENT for table `customerproductcrm`
--
ALTER TABLE `customerproductcrm`
  MODIFY `customerProductId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees_tasks`
--
ALTER TABLE `employees_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=921;

--
-- AUTO_INCREMENT for table `mailattachs`
--
ALTER TABLE `mailattachs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `messagecrm`
--
ALTER TABLE `messagecrm`
  MODIFY `CrmMessagesId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `my_calender`
--
ALTER TABLE `my_calender`
  MODIFY `calender_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paymenttypes`
--
ALTER TABLE `paymenttypes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permissioncrm`
--
ALTER TABLE `permissioncrm`
  MODIFY `permissioncrmId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `productcrm`
--
ALTER TABLE `productcrm`
  MODIFY `ProductCrmId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settingcrm`
--
ALTER TABLE `settingcrm`
  MODIFY `settingcrmId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `smsconfiguration`
--
ALTER TABLE `smsconfiguration`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `smtp_configuration`
--
ALTER TABLE `smtp_configuration`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `statuscrm`
--
ALTER TABLE `statuscrm`
  MODIFY `statusCrmId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usercrm`
--
ALTER TABLE `usercrm`
  MODIFY `userCrmId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_call_status`
--
ALTER TABLE `user_call_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_messages`
--
ALTER TABLE `user_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `call_status2`
--
ALTER TABLE `call_status2`
  ADD CONSTRAINT `call_status2_ibfk_1` FOREIGN KEY (`Status_Parent`) REFERENCES `call_status2` (`id`);

--
-- Constraints for table `client_notes`
--
ALTER TABLE `client_notes`
  ADD CONSTRAINT `client_notes_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `customercrm` (`customerCrmId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_notes_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `usercrm` (`userCrmId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_orders`
--
ALTER TABLE `client_orders`
  ADD CONSTRAINT `client_orders_ibfk_1` FOREIGN KEY (`Client_ID`) REFERENCES `customercrm` (`customerCrmId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_orders_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_orders_details`
--
ALTER TABLE `client_orders_details`
  ADD CONSTRAINT `client_orders_details_ibfk_1` FOREIGN KEY (`Order_ID`) REFERENCES `client_orders` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_orders_details_ibfk_2` FOREIGN KEY (`Payment_ID`) REFERENCES `paymenttypes` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `client_orders_details_ibfk_3` FOREIGN KEY (`Transfer_ID`) REFERENCES `crm_transfer_type` (`transfer_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `client_orders_details_ibfk_4` FOREIGN KEY (`Unit_ID`) REFERENCES `crm_products` (`Product_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `client_payments`
--
ALTER TABLE `client_payments`
  ADD CONSTRAINT `client_payments_ibfk_1` FOREIGN KEY (`Client_ID`) REFERENCES `customercrm` (`customerCrmId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_payments_ibfk_2` FOREIGN KEY (`Order_ID`) REFERENCES `client_orders` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_payments_ibfk_3` FOREIGN KEY (`User_ID`) REFERENCES `crm_users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `complaints_ibfk_2` FOREIGN KEY (`Client_ID`) REFERENCES `customercrm` (`customerCrmId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `complaints_ibfk_3` FOREIGN KEY (`To_User`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `complaints_details`
--
ALTER TABLE `complaints_details`
  ADD CONSTRAINT `complaints_details_ibfk_1` FOREIGN KEY (`complaints_ID`) REFERENCES `complaints` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `complaints_details_ibfk_2` FOREIGN KEY (`Owner_ID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `crm_calls`
--
ALTER TABLE `crm_calls`
  ADD CONSTRAINT `crm_calls_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `customercrm` (`customerCrmId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crm_calls_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crm_calls_ibfk_3` FOREIGN KEY (`call_Result`) REFERENCES `call_status` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `crm_calls_ibfk_4` FOREIGN KEY (`CommentID`) REFERENCES `crm_comments` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `crm_call_notifications`
--
ALTER TABLE `crm_call_notifications`
  ADD CONSTRAINT `crm_call_notifications_ibfk_1` FOREIGN KEY (`FollowID`) REFERENCES `crm_follows` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crm_call_notifications_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `crm_users` (`ID`);

--
-- Constraints for table `crm_comments`
--
ALTER TABLE `crm_comments`
  ADD CONSTRAINT `crm_comments_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `customercrm` (`customerCrmId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crm_comments_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crm_comments_ibfk_3` FOREIGN KEY (`FollowID`) REFERENCES `crm_follows` (`ID`);

--
-- Constraints for table `crm_empnotifications`
--
ALTER TABLE `crm_empnotifications`
  ADD CONSTRAINT `crm_empnotifications_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `crm_follows`
--
ALTER TABLE `crm_follows`
  ADD CONSTRAINT `crm_follows_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crm_follows_ibfk_2` FOREIGN KEY (`ClientID`) REFERENCES `customercrm` (`customerCrmId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `crm_internal_messages`
--
ALTER TABLE `crm_internal_messages`
  ADD CONSTRAINT `crm_internal_messages_ibfk_2` FOREIGN KEY (`Client_ID`) REFERENCES `customercrm` (`customerCrmId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crm_internal_messages_ibfk_3` FOREIGN KEY (`From_User`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crm_internal_messages_ibfk_4` FOREIGN KEY (`To_User`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crm_internal_messages_ibfk_5` FOREIGN KEY (`Message_Type`) REFERENCES `crm_internal_messages_types` (`ID`),
  ADD CONSTRAINT `crm_internal_messages_ibfk_6` FOREIGN KEY (`ownerUserID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `crm_mails`
--
ALTER TABLE `crm_mails`
  ADD CONSTRAINT `crm_mails_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `customercrm` (`customerCrmId`),
  ADD CONSTRAINT `crm_mails_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `crm_users` (`ID`);

--
-- Constraints for table `crm_messages`
--
ALTER TABLE `crm_messages`
  ADD CONSTRAINT `crm_messages_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `crm_users` (`ID`);

--
-- Constraints for table `crm_messages_details`
--
ALTER TABLE `crm_messages_details`
  ADD CONSTRAINT `crm_messages_details_ibfk_1` FOREIGN KEY (`Message_ID`) REFERENCES `crm_messages` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crm_messages_details_ibfk_2` FOREIGN KEY (`Owner_ID`) REFERENCES `crm_users` (`ID`);

--
-- Constraints for table `crm_messages_users`
--
ALTER TABLE `crm_messages_users`
  ADD CONSTRAINT `crm_messages_users_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `crm_users` (`ID`),
  ADD CONSTRAINT `crm_messages_users_ibfk_2` FOREIGN KEY (`MessageID`) REFERENCES `crm_messages` (`ID`);

--
-- Constraints for table `crm_notifications`
--
ALTER TABLE `crm_notifications`
  ADD CONSTRAINT `crm_notifications_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `crm_orders`
--
ALTER TABLE `crm_orders`
  ADD CONSTRAINT `crm_orders_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `customercrm` (`customerCrmId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crm_orders_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `crm_products` (`Product_ID`),
  ADD CONSTRAINT `crm_orders_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crm_orders_ibfk_4` FOREIGN KEY (`transfer_id`) REFERENCES `crm_transfer_type` (`transfer_ID`);

--
-- Constraints for table `crm_ordersettings`
--
ALTER TABLE `crm_ordersettings`
  ADD CONSTRAINT `crm_ordersettings_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `crm_ordersettings` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `crm_sms`
--
ALTER TABLE `crm_sms`
  ADD CONSTRAINT `crm_sms_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crm_sms_ibfk_2` FOREIGN KEY (`ClientID`) REFERENCES `customercrm` (`customerCrmId`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `crm_users`
--
ALTER TABLE `crm_users`
  ADD CONSTRAINT `crm_users_ibfk_1` FOREIGN KEY (`Super`) REFERENCES `crm_users` (`ID`),
  ADD CONSTRAINT `crm_users_ibfk_2` FOREIGN KEY (`Type`) REFERENCES `crm_userstypes` (`ID`);

--
-- Constraints for table `crm_users_log`
--
ALTER TABLE `crm_users_log`
  ADD CONSTRAINT `crm_users_log_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crm_users_log_ibfk_2` FOREIGN KEY (`Status`) REFERENCES `user_call_status` (`id`);

--
-- Constraints for table `crm_users_permissions`
--
ALTER TABLE `crm_users_permissions`
  ADD CONSTRAINT `crm_users_permissions_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crm_users_permissions_ibfk_2` FOREIGN KEY (`Object_Code`) REFERENCES `crm_permissions_objects` (`Code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customercrm`
--
ALTER TABLE `customercrm`
  ADD CONSTRAINT `customercrm_ibfk_1` FOREIGN KEY (`addedby`) REFERENCES `crm_users` (`ID`);

--
-- Constraints for table `employees_tasks`
--
ALTER TABLE `employees_tasks`
  ADD CONSTRAINT `employees_tasks_ibfk_1` FOREIGN KEY (`clientID`) REFERENCES `customercrm` (`customerCrmId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employees_tasks_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employees_tasks_ibfk_3` FOREIGN KEY (`Status`) REFERENCES `call_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `employees_tasks_ibfk_4` FOREIGN KEY (`supervisor_ID`) REFERENCES `crm_users` (`ID`),
  ADD CONSTRAINT `employees_tasks_ibfk_5` FOREIGN KEY (`Distributor_By`) REFERENCES `crm_users` (`ID`);

--
-- Constraints for table `mailattachs`
--
ALTER TABLE `mailattachs`
  ADD CONSTRAINT `mailattachs_ibfk_1` FOREIGN KEY (`MailID`) REFERENCES `crm_mails` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `smtp_configuration`
--
ALTER TABLE `smtp_configuration`
  ADD CONSTRAINT `smtp_configuration_ibfk_1` FOREIGN KEY (`Emp_ID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_messages`
--
ALTER TABLE `user_messages`
  ADD CONSTRAINT `user_messages_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `crm_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `Every_Minute_Insert_Delayed_Calls` ON SCHEDULE EVERY 1 MINUTE STARTS '2019-02-11 16:19:14' ON COMPLETION NOT PRESERVE ENABLE DO INSERT into user_messages(userID,Delayed_Calls)
select * from (select Users.UID as userID,(CASE WHEN callcount.cCount IS NULL THEN 0 ELSE callcount.cCount END) as Delayed_Calls from
 (select DISTINCT(userID) AS UID FROM crm_follows) as Users 
 LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 crm_follows WHERE crm_follows.Follow_Date = date(now()) 
 AND (time(DATE_ADD(crm_follows.Follow_Time,INTERVAL 15 MINUTE)) >= time(now()) 
 And crm_follows.Follow_Time < time(now())) GROUP By userID) as callcount 
 on Users.UID = callcount.userID ) as userCallCount
 WHERE  userCallCount.userID NOT in (select userID FROM user_messages)$$

CREATE DEFINER=`root`@`localhost` EVENT `Every_Minute_Update_UpcommingCalls` ON SCHEDULE EVERY 1 MINUTE STARTS '2019-02-11 16:08:12' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE user_messages INNER JOIN (select * from (select Users.UID as userID,(CASE WHEN callcount.cCount IS NULL THEN 0 ELSE callcount.cCount END) as UpcommingCalls from
 (select DISTINCT(userID) AS UID FROM crm_follows) as Users 
 LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 crm_follows WHERE crm_follows.Follow_Date = date(now()) 
 AND (crm_follows.Follow_Time <= time(DATE_ADD(now(),INTERVAL 15 MINUTE)) 
 And crm_follows.Follow_Time > time(now())) GROUP By userID) as callcount 
 on Users.UID = callcount.userID ) as userCallCount
 WHERE  userCallCount.userID in (select userID FROM user_messages)) as userData on 
user_messages.userID = userData.userID
SET user_messages.UpcommingCalls = userData.UpcommingCalls,
user_messages.UpcommingCalls_Seen = 0$$

CREATE DEFINER=`root`@`localhost` EVENT `Every_Minute_Update_DelayedForSupervisor_Calls` ON SCHEDULE EVERY 1 MINUTE STARTS '2019-02-14 14:07:56' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE user_messages INNER JOIN (select * from 
(select Users.UID as userID,(CASE WHEN callcount.cCount IS NULL THEN 0 ELSE callcount.cCount END) 
as Delayed_Calls from
 (select DISTINCT(userID) AS UID FROM crm_follows) as Users 
 LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 crm_follows WHERE crm_follows.Follow_Date = date(now()) 
 AND (time(DATE_ADD(crm_follows.Follow_Time,INTERVAL 30 MINUTE)) >= time(now()) AND time(DATE_ADD(crm_follows.Follow_Time,INTERVAL 15 MINUTE)) < time(now())
 And crm_follows.Follow_Time < time(now())) GROUP By userID) as callcount 
 on Users.UID = callcount.userID ) as userCallCount
 WHERE  userCallCount.userID in (select userID FROM user_messages)) as userData on 
user_messages.userID = userData.userID
SET user_messages.Delayed_ForSupervisor = userData.Delayed_Calls$$

CREATE DEFINER=`root`@`localhost` EVENT `Every_Minute_Insetr_UpcommingCalls` ON SCHEDULE EVERY 1 MINUTE STARTS '2019-02-11 16:08:37' ON COMPLETION NOT PRESERVE ENABLE DO INSERT into user_messages(userID,UpcommingCalls)
select * from (select Users.UID as userID,(CASE WHEN callcount.cCount IS NULL THEN 0 ELSE callcount.cCount END) as UpcommingCalls from
 (select DISTINCT(userID) AS UID FROM crm_follows) as Users 
 LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 crm_follows WHERE crm_follows.Follow_Date = date(now()) 
 AND (crm_follows.Follow_Time <= time(DATE_ADD(now(),INTERVAL 15 MINUTE)) 
 And crm_follows.Follow_Time > time(now())) GROUP By userID) as callcount 
 on Users.UID = callcount.userID ) as userCallCount
 WHERE  userCallCount.userID NOT in (select userID FROM user_messages)$$

CREATE DEFINER=`root`@`localhost` EVENT `Every_Minute_Update_DelayedForAdmin_Calls` ON SCHEDULE EVERY 1 MINUTE STARTS '2019-02-14 14:06:54' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE user_messages INNER JOIN (select * from 
(select Users.UID as userID,(CASE WHEN callcount.cCount IS NULL THEN 0 ELSE callcount.cCount END) 
as Delayed_Calls from
 (select DISTINCT(userID) AS UID FROM crm_follows) as Users 
 LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 crm_follows WHERE crm_follows.Follow_Date < date(now())
 or (crm_follows.Follow_Date = date(now()) 
 and time(DATE_ADD(crm_follows.Follow_Time,INTERVAL 45 MINUTE)) < time(now()))            GROUP By userID) 
  as callcount 
 on Users.UID = callcount.userID ) as userCallCount
 WHERE  userCallCount.userID in (select userID FROM user_messages)) as userData on 
user_messages.userID = userData.userID
SET user_messages.Delayed_ForAdmin = userData.Delayed_Calls$$

CREATE DEFINER=`root`@`localhost` EVENT `Every_Minute_Update_Delayed_Calls` ON SCHEDULE EVERY 1 MINUTE STARTS '2019-02-11 16:18:28' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE user_messages INNER JOIN (select * from 
(select Users.UID as userID,(CASE WHEN callcount.cCount IS NULL THEN 0 ELSE callcount.cCount END) 
as Delayed_Calls from
 (select DISTINCT(userID) AS UID FROM crm_follows) as Users 
 LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 crm_follows WHERE crm_follows.Follow_Date = date(now()) 
 AND (time(DATE_ADD(crm_follows.Follow_Time,INTERVAL 15 MINUTE)) >= time(now()) 
 And crm_follows.Follow_Time < time(now())) GROUP By userID) as callcount 
 on Users.UID = callcount.userID ) as userCallCount
 WHERE  userCallCount.userID in (select userID FROM user_messages)) as userData on 
user_messages.userID = userData.userID
SET user_messages.Delayed_Calls = userData.Delayed_Calls,
user_messages.Delayed_Calls_Seen = 0$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
