-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2019 at 06:10 AM
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
AND customercrm.customerCrmCreateDate <= date2
AND customercrm.customerCrmCreateDate >= date1) as a1,(
select '2',count(*) as count2 from customercrm
WHERE `customerCrmAge` < 25 and `customerCrmAge` >= 20
AND customercrm.customerCrmCreateDate <= date2
AND customercrm.customerCrmCreateDate >= date1)as a2,(
select '3',count(*) as count3 from customercrm
WHERE `customerCrmAge` < 30 and `customerCrmAge` >= 25
AND customercrm.customerCrmCreateDate <= date2
AND customercrm.customerCrmCreateDate >= date1) as a3,(
select '4',count(*) as count4 from customercrm
WHERE `customerCrmAge` < 35 and `customerCrmAge` >= 30
AND customercrm.customerCrmCreateDate <= date2
AND customercrm.customerCrmCreateDate >= date1)as a4,(
select '5',count(*) as count5 from customercrm
WHERE `customerCrmAge` < 40 and `customerCrmAge` >= 35
AND customercrm.customerCrmCreateDate <= date2
AND customercrm.customerCrmCreateDate >= date1)as a5,(
select '6',count(*) as count6 from customercrm
WHERE `customerCrmAge` < 45 and `customerCrmAge` >= 40
AND customercrm.customerCrmCreateDate <= date2
AND customercrm.customerCrmCreateDate >= date1)as a6,(
select '7',count(*) as count7 from customercrm
WHERE `customerCrmAge` < 50 and `customerCrmAge` >= 45
AND customercrm.customerCrmCreateDate <= date2
AND customercrm.customerCrmCreateDate >= date1)as a7,(
select '8',count(*) as count8 from customercrm
WHERE `customerCrmAge` < 55 and `customerCrmAge` >= 50
AND customercrm.customerCrmCreateDate <= date2
AND customercrm.customerCrmCreateDate >= date1)as a8,(
select '9',count(*) as count9 from customercrm
WHERE `customerCrmAge` < 60 and `customerCrmAge` >= 55
AND customercrm.customerCrmCreateDate <= date2
AND customercrm.customerCrmCreateDate >= date1) as a9$$

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
WHERE customercrm.customerCrmCreateDate <= date2
AND customercrm.customerCrmCreateDate >= date1
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
WHERE customercrm.customerCrmCreateDate <= date2
AND customercrm.customerCrmCreateDate >= date1
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
(15, 1, 'متابعه', 1, 1, 1, 0),
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
(1, 483, 36, '2019-09-17 15:35:41', 0, 0, 100, 100, b'0'),
(2, 466, 39, '2019-09-17 15:59:55', 100, 160, 5000, 5060, b'0'),
(3, 483, 39, '2019-09-17 16:35:50', 0, 0, 500, 500, b'0'),
(4, 454, 40, '2019-09-17 17:05:07', 600, 50, 3000, 2450, b'0'),
(5, 452, 40, '2019-09-17 17:06:21', 0, 0, 500, 500, b'0'),
(6, 453, 40, '2019-09-17 17:07:52', 20, 60, 2000, 2040, b'0'),
(7, 462, 39, '2019-09-18 16:33:59', 0, 0, 1250, 1250, b'0');

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
(1, 1, 7, 7, 5, 100, 1),
(2, 2, 7, 7, 5, 100, 10),
(3, 2, 8, 7, 5, 100, 10),
(4, 2, 9, 7, 5, 100, 10),
(5, 2, 8, 8, 5, 100, 20),
(6, 3, 7, 7, 5, 100, 5),
(7, 4, 7, 7, 5, 100, 10),
(8, 4, 8, 7, 5, 100, 20),
(9, 5, 7, 9, 5, 100, 5),
(10, 6, 9, 8, 5, 100, 20),
(11, 7, 7, 7, 7, 150, 5),
(12, 7, 7, 7, 8, 10, 50);

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
(1, 483, 36, 1, 100, 0, '2019-09-17 15:35:41'),
(2, 466, 39, 2, 5060, 0, '2019-09-17 15:59:55'),
(3, 483, 39, 3, 500, 0, '2019-09-17 16:35:50'),
(4, 454, 40, 4, 2450, 0, '2019-09-17 17:05:07'),
(5, 452, 40, 5, 500, 0, '2019-09-17 17:06:21'),
(6, 453, 40, 6, 2040, 2040, '2019-09-17 17:07:52'),
(7, 462, 39, 7, 1250, 0, '2019-09-18 16:33:59');

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
(1, 'abdalraheem.kamel.work@gmail.com', 'smtp.gmail.com', '587', 'A!bdo*b/2020');

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
(1, 39, NULL, 462, 'شكوة عميل مش محترم', b'0', b'0', b'0', b'1', b'0', b'1', b'0'),
(2, 39, 35, 462, 'شكوة عميل محترم', b'0', b'0', b'0', b'1', b'1', b'1', b'0'),
(3, 39, 35, 462, 'ملاحظة عميل محترم', b'0', b'0', b'0', b'1', b'1', b'1', b'1'),
(4, 39, NULL, 462, 'ملاحظة عميل 2', b'0', b'0', b'0', b'0', b'0', b'1', b'1'),
(5, 3, NULL, 11, 'asdasdasdsa', b'0', b'0', b'0', b'1', b'0', b'1', b'0'),
(6, 39, 35, NULL, 'test message', b'1', b'0', b'0', b'0', b'0', b'0', b'0'),
(7, 39, NULL, NULL, 'test message', b'0', b'1', b'0', b'0', b'0', b'0', b'0');

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
(1, 1, 39, 'العميل ', '2019-09-18 15:26:58'),
(2, 1, 3, ' مالو', '2019-09-18 15:27:47'),
(3, 2, 39, 'العميل ', '2019-09-18 15:33:32'),
(4, 2, 35, 'عمل ايه', '2019-09-18 15:34:02'),
(5, 2, 3, ' فى ايه ؟؟', '2019-09-18 15:34:33'),
(6, 3, 39, 'السعر غالى', '2019-09-18 15:45:04'),
(7, 4, 39, 'العميل عندة عرض افضل', '2019-09-18 15:45:39'),
(8, 3, 3, ' خصم  105%', '2019-09-18 15:46:22'),
(9, 3, 35, ' لييييييييييييييييييييه ؟', '2019-09-18 15:47:07'),
(10, 1, 3, ' efrwef', '2019-09-28 00:07:46'),
(11, 1, 3, ' sdfdsfds', '2019-09-28 00:07:49'),
(12, 5, 3, '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;color:#16a085&quot;&gt;&lt;span style=&quot;font-size:22px&quot;&gt;asdfewfsdfdssdfdsaaw&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n', '2019-10-01 00:44:46'),
(13, 5, 3, '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;color:#2ecc71&quot;&gt;&lt;span style=&quot;font-size:48px&quot;&gt;&lt;span style=&quot;font-family:Comic Sans MS,cursive&quot;&gt;Test&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n', '2019-10-01 00:49:54'),
(14, 5, 3, '&lt;p&gt;&lt;span style=&quot;font-size:48px&quot;&gt;&lt;img alt=&quot;yes&quot; height=&quot;23&quot; src=&quot;http://localhost:8072/crm/design/vendors/ckeditor4-major/plugins/smiley/images/thumbs_up.png&quot; title=&quot;yes&quot; width=&quot;23&quot; /&gt;&lt;/span&gt;&lt;/p&gt;\r\n', '2019-10-01 00:50:11'),
(15, 6, 39, 'ajshdgasihjdbsa', '2019-10-01 00:54:44'),
(16, 7, 39, '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size:24px&quot;&gt;&lt;span style=&quot;font-family:Times New Roman,Times,serif&quot;&gt;&lt;span style=&quot;color:#16a085&quot;&gt;&lt;span style=&quot;background-color:#ecf0f1&quot;&gt;asjhasdjasdjhsagdjsahgdjsaasjhasdjasdjhsagdjsahgdjsaasjhasdjasdjhsagdjsahgdjsaasjhasdjasdjhsagdjsahgdjsaasjhasdjasdjhsagdjsahgdjsa&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n', '2019-10-01 00:56:38');

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
(13, 33, 1, '2019-09-14', '14:45:01', '14:50:05', 15, NULL),
(14, 33, 2, '2019-09-14', '14:50:14', '00:00:00', NULL, NULL),
(15, 33, 2, '2019-09-14', '14:50:23', '14:50:34', 15, NULL),
(16, 33, 11, '2019-09-14', '14:50:41', '14:50:55', 15, NULL),
(17, 33, 101, '2019-09-14', '14:51:04', '14:51:17', 15, NULL),
(18, 33, 102, '2019-09-14', '14:51:25', '14:51:35', 15, NULL),
(19, 33, 103, '2019-09-14', '15:35:56', '15:36:10', 15, NULL),
(20, 33, 104, '2019-09-14', '15:36:53', '15:37:05', 21, NULL),
(21, 33, 105, '2019-09-14', '15:37:18', '15:37:29', 29, NULL),
(22, 33, 106, '2019-09-14', '15:37:54', '15:38:05', 36, NULL),
(23, 33, 107, '2019-09-14', '15:38:16', '15:38:30', 38, NULL),
(24, 33, 108, '2019-09-14', '15:38:49', '15:39:02', 39, NULL),
(25, 33, 109, '2019-09-14', '15:39:13', '15:39:24', 25, NULL),
(26, 33, 110, '2019-09-14', '15:39:36', '15:39:47', 26, NULL),
(27, 33, 12, '2019-09-14', '15:39:59', '15:40:14', 27, NULL),
(28, 33, 111, '2019-09-14', '15:40:24', '15:40:33', 31, NULL),
(29, 33, 112, '2019-09-14', '15:41:00', '15:41:05', 32, NULL),
(30, 33, 113, '2019-09-14', '15:41:18', '15:41:23', 33, NULL),
(31, 33, 114, '2019-09-14', '15:41:34', '15:41:39', 35, NULL),
(32, 33, 107, '2019-09-16', '15:32:31', '15:32:57', 15, NULL),
(33, 33, 2, '2019-09-16', '15:33:41', '15:33:53', 15, NULL),
(34, 33, 107, '2019-09-16', '15:52:01', '15:52:14', 15, NULL),
(35, 33, 11, '2019-09-16', '16:16:01', '16:16:25', 15, NULL),
(37, 36, 482, '2019-09-17', '15:27:34', '15:27:50', 15, NULL),
(38, 36, 483, '2019-09-17', '15:28:00', '00:00:00', NULL, NULL),
(39, 36, 485, '2019-09-17', '15:28:09', '15:28:37', 32, 2),
(40, 36, 487, '2019-09-17', '15:28:43', '15:29:08', 33, 3),
(41, 36, 486, '2019-09-17', '15:30:25', '15:30:41', 35, 4),
(42, 36, 484, '2019-09-17', '15:31:00', '15:31:30', 31, NULL),
(43, 36, 483, '2019-09-17', '15:34:33', '15:35:41', 4, NULL),
(44, 39, 467, '2019-09-17', '15:55:22', '15:55:46', 39, NULL),
(45, 39, 468, '2019-09-17', '15:56:08', '15:56:22', 36, NULL),
(46, 39, 462, '2019-09-17', '15:56:29', '15:56:41', 29, NULL),
(47, 39, 463, '2019-09-17', '15:56:49', '15:56:56', 35, NULL),
(48, 39, 466, '2019-09-17', '15:57:05', '00:00:00', NULL, NULL),
(49, 39, 469, '2019-09-17', '15:57:13', '15:57:27', 25, NULL),
(50, 39, 466, '2019-09-17', '15:57:34', '15:59:55', 7, NULL),
(51, 39, 465, '2019-09-17', '16:48:23', '16:48:41', 27, NULL),
(52, 40, 451, '2019-09-17', '17:03:01', '17:03:12', 26, NULL),
(53, 40, 455, '2019-09-17', '17:03:18', '17:03:25', 35, NULL),
(54, 40, 452, '2019-09-17', '17:03:32', '17:03:46', 15, NULL),
(55, 40, 454, '2019-09-17', '17:03:53', '17:05:07', 7, NULL),
(56, 40, 454, '2019-09-17', '17:05:36', '00:00:00', NULL, NULL),
(57, 40, 452, '2019-09-17', '17:05:50', '17:06:21', 7, NULL),
(58, 40, 453, '2019-09-17', '17:07:13', '17:07:52', 40, NULL),
(59, 40, 453, '2019-09-17', '17:08:09', '17:09:10', 41, NULL),
(60, 40, 453, '2019-09-17', '17:09:14', '17:09:36', NULL, NULL),
(61, 40, 453, '2019-09-17', '17:09:43', '00:00:00', NULL, NULL),
(62, 40, 457, '2019-09-17', '17:45:29', '17:45:40', 31, NULL),
(63, 39, 461, '2019-09-18', '12:09:00', '12:09:12', 15, NULL),
(64, 39, 464, '2019-09-18', '12:09:21', '12:09:39', 15, NULL),
(65, 39, 470, '2019-09-18', '12:09:51', '12:10:06', 15, NULL),
(66, 39, 462, '2019-09-18', '16:33:18', '16:33:59', 4, NULL),
(67, 39, 462, '2019-09-18', '16:44:55', '00:00:00', NULL, NULL),
(68, 39, 462, '2019-09-18', '16:45:26', '00:00:00', NULL, NULL),
(69, 39, 462, '2019-09-18', '16:45:50', '16:46:02', NULL, NULL),
(70, 39, 462, '2019-09-18', '16:46:10', '16:46:36', 25, NULL);

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
(6, 33, b'1', b'1', b'1', b'1', b'1', b'1', 8, b'1', b'1'),
(7, 33, b'1', b'1', b'1', b'1', b'1', b'1', 9, b'1', b'1'),
(8, 33, b'1', b'1', b'1', b'1', b'1', b'1', 10, b'1', b'1'),
(9, 33, b'1', b'1', b'1', b'1', b'1', b'1', 11, b'1', b'1'),
(10, 33, b'1', b'1', b'1', b'1', b'1', b'1', 12, b'1', b'1'),
(11, 33, b'1', b'1', b'1', b'1', b'1', b'1', 13, b'1', b'1'),
(12, 33, b'1', b'1', b'1', b'1', b'1', b'1', 14, b'1', b'1'),
(13, 33, b'1', b'1', b'1', b'1', b'1', b'1', 15, b'1', b'1'),
(14, 33, b'1', b'1', b'1', b'1', b'1', b'1', 16, b'1', b'1'),
(15, 33, b'1', b'1', b'1', b'1', b'1', b'1', 17, b'1', b'1'),
(17, 36, b'1', b'1', b'1', b'1', b'1', b'1', 19, b'0', b'1'),
(19, 39, b'1', b'1', b'1', b'1', b'1', b'1', 21, b'0', b'1'),
(20, 39, b'1', b'1', b'1', b'1', b'1', b'1', 22, b'0', b'1'),
(21, 39, b'1', b'1', b'1', b'1', b'1', b'1', 23, b'0', b'1'),
(22, 39, b'1', b'1', b'1', b'1', b'1', b'1', 24, b'0', b'1'),
(23, 39, b'1', b'1', b'1', b'1', b'1', b'1', 25, b'1', b'1');

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
(2, 36, 485, 'الرقم غير موجود بالخدمة الرجاء تعديل بيانات العميل', '2019-09-17', '15:28:37', b'0', NULL),
(3, 36, 487, 'الرقم غير صحيح ', '2019-09-17', '15:29:08', b'0', NULL),
(4, 36, 486, 'بياناتى العميل غير صحيحة \r\n', '2019-09-17', '15:30:41', b'0', NULL),
(5, 3, 11, 'زز', '2019-09-19', '17:22:52', b'0', NULL),
(6, 3, 11, '00', '2019-09-19', '17:22:55', b'0', NULL),
(7, 3, 11, '00', '2019-09-19', '17:22:59', b'0', NULL),
(8, 3, 11, '00', '2019-09-19', '17:23:02', b'0', NULL),
(9, 3, 251, '00', '2019-09-19', '17:27:41', b'0', NULL),
(10, 3, 11, '', '2019-10-01', '00:29:20', b'0', NULL),
(11, 3, 11, '', '2019-10-01', '00:35:01', b'0', NULL),
(12, 3, 11, '&lt;h1 style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-family:Comic Sans MS,cursive&quot;&gt;&lt;span style=&quot;color:#27ae60&quot;&gt;ewfdgdfgregw&lt;/span&gt;&lt;/span&gt;&lt;/h1&gt;\n', '2019-10-01', '00:35:56', b'0', NULL);

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
(8, 33, 1, '2019-09-14', '15:00:00'),
(9, 33, 2, '2019-09-16', '15:50:00'),
(10, 32, 11, '2019-09-16', '17:35:13'),
(11, 32, 101, '2019-09-18', '17:15:11'),
(12, 33, 102, '2019-09-14', '15:00:00'),
(13, 32, 103, '2019-09-18', '17:15:11'),
(14, 33, 104, '2019-09-14', '15:45:00'),
(15, 33, 105, '2019-09-14', '15:40:00'),
(16, 33, 109, '2019-09-16', '17:35:27'),
(17, 32, 107, '2019-09-16', '17:35:13'),
(19, 36, 482, '2019-09-17', '15:35:00'),
(21, 39, 469, '2019-09-17', '16:30:00'),
(22, 39, 461, '2019-09-18', '12:20:00'),
(23, 39, 464, '2019-09-18', '12:20:00'),
(24, 39, 470, '2019-09-18', '12:20:00'),
(25, 39, 462, '2019-09-18', '16:45:00');

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
  `Mail` varchar(50) NOT NULL,
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
(1, 3, 11, 'abdob2623@gmail.com', 'test7', 'asd', '2019-09-26', b'0', b'0', b'0'),
(2, 3, 11, 'abdob2623@gmail.com', 'test10', 'asdas', '2019-09-26', b'0', b'0', b'0'),
(3, 3, NULL, 'abdob2623@gmail.com', 'test message2255', 'yasfdgam', '2019-09-26', b'0', b'0', b'0'),
(4, 3, 1, 'abdob2623@gmail.com', 'test Attach', '4 Files', '0000-00-00', b'0', b'0', b'0'),
(5, 3, 1, 'abdob2623@gmail.com', 'test Attach', '4 Files', '2019-09-28', b'0', b'0', b'0'),
(6, 3, 1, 'abdob2623@gmail.com', 'dsfds', 'sdfsd', '2019-09-28', b'0', b'0', b'0'),
(7, 3, 1, 'abdob2623@gmail.com', 'adsa', 'asdasda', '2019-09-28', b'0', b'0', b'0'),
(8, 3, 1, 'abdob2623@gmail.com', 'Final Test', 'Test 3 Files', '2019-09-28', b'0', b'0', b'0'),
(9, 3, NULL, 'abdob2623@gmail.com;a.kamel@quantumsit.com;', 'test message', '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size:22px&quot;&gt;Test Message Title&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p style=&quot;text-align:left&quot;&gt;&lt;span style=&quot;font-size:22px&quot;&gt;&lt;span style=&quot;color:#e74c3c&quot;&gt;Test Color Body&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n', '2019-09-30', b'0', b'0', b'0'),
(10, 3, NULL, 'abdob2623@gmail.com;a.kamel@quantumsit.com;', 'test message22', '&lt;h1 style=&quot;text-align:center&quot;&gt;qweqwewq&lt;/h1&gt;\r\n\r\n&lt;div style=&quot;margin-right:80px; text-align:left&quot;&gt;&lt;span style=&quot;background-color:#2ecc71&quot;&gt;asdsadsadassadasdasasd&lt;/span&gt;&lt;/div&gt;\r\n', '2019-09-30', b'0', b'0', b'0'),
(11, 3, NULL, 'abdob2623@gmail.com;', 'asasd', '&lt;p style=&quot;text-align:center&quot;&gt;asdadsadasdsa&lt;/p&gt;\r\n', '2019-09-30', b'0', b'0', b'0'),
(12, 3, NULL, 'abdob2623@gmail.com;', 'test messagess', '&lt;p style=&quot;text-align:center&quot;&gt;asdsadsa&lt;/p&gt;\r\n', '2019-09-30', b'0', b'0', b'0'),
(13, 3, NULL, 'abdob2623@gmail.com;', 'test message', '&lt;p style=&quot;text-align:center&quot;&gt;asdasdasdsadsasadd&lt;/p&gt;\r\n', '2019-09-30', b'0', b'0', b'0'),
(14, 3, NULL, 'abdob2623@gmail.com;', 'asd', '&lt;p&gt;aasdasdsa&lt;/p&gt;\r\n', '2019-09-30', b'0', b'0', b'0'),
(15, 3, NULL, 'abdob2623@gmail.com;', 'asdasdasd', '&lt;p style=&quot;text-align:center&quot;&gt;asdasdasdasdasdsa&lt;/p&gt;\r\n', '2019-09-30', b'0', b'0', b'0'),
(16, 3, NULL, 'abdob2623@gmail.com;', 'ukfdhth iuerhgiujhafoqy', '&lt;p style=&quot;text-align:center&quot;&gt;adsfewfjhagkjfhbarg&lt;/p&gt;\r\n', '2019-09-30', b'0', b'0', b'0'),
(17, 3, NULL, 'abdob2623@gmail.com;', 'saddsadsa', '&lt;p&gt;asdasdsadsa&lt;/p&gt;\r\n', '2019-09-30', b'0', b'0', b'0'),
(18, 3, NULL, 'abdob2623@gmail.com;', 'sadsadsa', '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;background-color:#2ecc71&quot;&gt;asdadasdasdsadsadasdsadsa&lt;/span&gt;&lt;/p&gt;\r\n', '2019-09-30', b'0', b'0', b'0'),
(19, 3, NULL, 'abdob2623@gmail.com;', 'sadsadsa', '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;background-color:#2ecc71&quot;&gt;asdadasdasdsadsadasdsadsa&lt;/span&gt;&lt;/p&gt;\r\n', '2019-09-30', b'0', b'0', b'0'),
(20, 3, NULL, 'abdob2623@gmail.com;', 'test message With Format', '&lt;h1 style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;color:#e67e22&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:Courier New,Courier,monospace&quot;&gt;TEst Title&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/h1&gt;\r\n\r\n&lt;div style=&quot;text-align:left&quot;&gt;&lt;span style=&quot;color:#ecf0f1&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;font-family:Courier New,Courier,monospace&quot;&gt;&lt;span style=&quot;background-color:#8e44ad&quot;&gt;Test Body&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n', '2019-09-30', b'0', b'0', b'0'),
(21, 3, 1, 'abdob2623@gmail.com', 'test message', '<h1 style=\"margin-right:40px; text-align:center\">asdsadsadsadsadasd</h1>\r\n\r\n<div>\r\n<hr />\r\n<p>jdsfjsdfgjhdgfjhdsgfjds</p>\r\n\r\n<hr />\r\n<p>jshdfgjhdbfkdsfds<img alt=\"yes\" height=\"23\" src=\"http://localhost:8072/crm/design/vendors/ckeditor4-major/plugins/smiley/images/thumbs_up.png\" title=\"yes\" width=\"23\" /></p>\r\n</div>\r\n', '2019-09-30', b'0', b'0', b'0'),
(22, 3, 1, 'abdob2623@gmail.com', 'test messagess222', '<p style=\"text-align:center\">jsadfdsjgfjkhdsfsd</p>\r\n\r\n<hr />\r\n<p>kfdghkfdjhkjfdg</p>\r\n', '2019-09-30', b'0', b'0', b'0'),
(23, 3, 11, 'abdob2623@gmail.com', 'test message545125312', '', '2019-09-30', b'0', b'0', b'0'),
(24, 3, NULL, 'abdob2623@gmail.com', 'test message545125312', '<p style=\"text-align:center\">qweqwewqewqweqqweqw</p>\r\n\r\n<p style=\"text-align:center\"><span style=\"color:#c0392b\"><span style=\"font-size:22px\">wqeqwee<big>wq</big></span></span></p>\r\n', '2019-09-30', b'0', b'0', b'0'),
(25, 3, NULL, 'abdob2623@gmail.com', 'test messageqwe211212', '<p style=\"text-align:center\"><span style=\"font-family:Tahoma,Geneva,sans-serif\"><span style=\"background-color:#27ae60\">asdsjhgujewf</span></span></p>\r\n\r\n<div style=\"page-break-after:always\"><span style=\"display:none\">&nbsp;</span></div>\r\n\r\n<p style=\"text-align:center\"><span style=\"font-family:Tahoma,Geneva,sans-serif\"><span style=\"background-color:#27ae60\">ahsdfhasfdsa</span></span></p>\r\n\r\n<hr />\r\n<p><span style=\"font-family:Tahoma,Geneva,sans-serif\"><span style=\"background-color:#27ae60\">sjdfjdsfgjdsfs</span></span></p>\r\n', '2019-09-30', b'0', b'0', b'0'),
(26, 3, NULL, 'abdob2623@gmail.com', 'Test Message For 3 time', '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size:36px&quot;&gt;Test Formated Message&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;hr /&gt;\r\n&lt;p style=&quot;text-align:left&quot;&gt;&lt;span style=&quot;background-color:#3498db&quot;&gt;Messae Body&lt;/span&gt;&lt;/p&gt;\r\n', '2019-10-01', b'0', b'0', b'0'),
(27, 3, NULL, 'abdob2623@gmail.com', 'Test Message For 3 time', '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size:36px&quot;&gt;Test Formated Message&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;hr /&gt;\r\n&lt;p style=&quot;text-align:left&quot;&gt;&lt;span style=&quot;background-color:#3498db&quot;&gt;Messae Body&lt;/span&gt;&lt;/p&gt;\r\n', '2019-10-01', b'0', b'0', b'0'),
(28, 3, NULL, 'abdob2623@gmail.com', 'Test Message For 3 time', '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size:36px&quot;&gt;Test Formated Message&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;hr /&gt;\r\n&lt;p style=&quot;text-align:left&quot;&gt;&lt;span style=&quot;background-color:#3498db&quot;&gt;Messae Body&lt;/span&gt;&lt;/p&gt;\r\n', '2019-10-01', b'0', b'0', b'0'),
(29, 3, 466, 'abdob2623@gmail.com', 'test to clients', '&lt;p style=&quot;text-align:center&quot;&gt;dfsdfdsfdsfdsdsfds&lt;/p&gt;\r\n', '2019-10-01', b'0', b'0', b'0'),
(30, 3, 452, 'abdob2623@gmail.com', 'test to clients', '&lt;p style=&quot;text-align:center&quot;&gt;dfsdfdsfdsfdsdsfds&lt;/p&gt;\r\n', '2019-10-01', b'0', b'0', b'0'),
(31, 3, 454, 'abdob2623@gmail.com', 'test to clients', '&lt;p style=&quot;text-align:center&quot;&gt;dfsdfdsfdsfdsdsfds&lt;/p&gt;\r\n', '2019-10-01', b'0', b'0', b'0');

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
(1, 33, 'final ', b'0', b'0'),
(2, 32, 'e2e', b'0', b'0'),
(3, 39, 'test', b'0', b'0'),
(4, 39, 'test', b'0', b'0'),
(6, 39, 'صباح الخير صباح الخير صباح الخير صباح الخيرصباح الخير صباح الخيرصباح الخير صباح الخيرصباح الخير صباح', b'0', b'0'),
(7, 39, 'صباح الخير صباح الخير صباح الخير صباح الخيرصباح الخير صباح الخيرصباح الخير صباح الخيرصباح الخير صباح', b'0', b'0'),
(8, 3, 'test messageyy', b'1', b'1'),
(11, 32, 'asdasdasdsa', b'0', b'0'),
(12, 32, 'test message56786', b'0', b'0');

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
(1, 1, 33, 'test', '2019-09-16 16:29:09'),
(2, 2, 32, '3w3w', '2019-09-16 16:31:57'),
(3, 2, 3, ' 333`', '2019-09-16 16:32:10'),
(4, 2, 3, 'test2000', '2019-09-16 16:33:26'),
(5, 3, 39, 'asd', '2019-09-18 13:32:38'),
(6, 4, 39, 'asd', '2019-09-18 13:32:38'),
(7, 4, 3, ' تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست تايسلتسنيانيلبيست', '2019-09-18 13:37:07'),
(11, 6, 39, 'صباح الخير صباح الخيرصباح الخير صباح الخيرصباح الخير صباح الخير', '2019-09-18 13:55:08'),
(12, 7, 39, 'صباح الخير صباح الخيرصباح الخير صباح الخيرصباح الخير صباح الخير', '2019-09-18 13:55:08'),
(13, 6, 32, ' صباح النور', '2019-09-18 14:11:07'),
(14, 7, 35, 'عايزة ايه \r\n', '2019-09-18 14:19:33'),
(15, 7, 3, 'كل واحدة على مكتبة', '2019-09-18 14:25:48'),
(16, 6, 3, ' كل واحدة على مكتبة\r\n\r\n', '2019-09-18 14:28:32'),
(17, 7, 3, ' asjhkdfgidsa\r\n', '2019-09-28 16:48:45'),
(18, 8, 3, 'rtryryryrrtrtyrtyrt', '2019-10-01 04:34:52'),
(20, 11, 32, 'asdsadasdsa', '2019-10-01 05:31:01'),
(21, 12, 32, '78678678678', '2019-10-01 05:38:31'),
(22, 8, 3, '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size:36px&quot;&gt;&lt;span style=&quot;color:#c0392b&quot;&gt;jhrughfdjkhgkdshiugre&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n', '2019-10-01 05:42:36'),
(23, 8, 32, '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;background-color:#3498db&quot;&gt;jsdkhgiufwhfwvd&lt;/span&gt;&lt;/p&gt;\r\n', '2019-10-01 05:47:16'),
(24, 8, 33, '&lt;p style=&quot;text-align:center&quot;&gt;asdkqwiqwgeiuyqegw2qwe&lt;/p&gt;\r\n', '2019-10-01 05:47:58');

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
(1, 8, 32, b'0', b'1'),
(6, 11, 33, b'0', b'0'),
(8, 12, 3, b'0', b'0');

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
(5, 'دليل تارجيت الاصدار الاول', 1, 100, 'دليل الشريكات المصرية'),
(7, 'دليل تارجيت الاصدار الثانى', 1, 150, 'تحديث دليل تارجيت الاصدار الاول'),
(8, 'سيريال', 2, 10, 'سيريال تفعيل برنامج الدليل');

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
(1, 39, 461, '201140218187', 'test SMS', '2019-09-18', b'0', b'0', b'0'),
(3, 39, 462, '201114355330', 'sms test sms test sms test sms test sms test sms test sms test sms test sms test sms test sms test ', '2019-09-18', b'0', b'0', b'0'),
(4, 3, NULL, '201114355330', '00', '2019-09-19', b'0', b'0', b'0'),
(5, 3, NULL, '201114355330', '12354', '2019-09-28', b'0', b'0', b'0');

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
(32, 'هبه', 'abdob2623@gmail.com', '01114355330', 'test', NULL, '2019-04-30', 1, 1, 1, '2019-07-02', 'heba', '202cb962ac59075b964b07152d234b70', 2, NULL, 1, 10, 'heba.jpg'),
(33, 'منار', 'abdob2623@gmail.com111', '01114355330', 'test', NULL, '2019-05-27', 1, 1, 1, '2019-07-29', 'manar', '202cb962ac59075b964b07152d234b70', 3, 32, 1, 10, NULL),
(34, 'ريهام', 'abdob2623@gmail.com1', '01114355330', 'test', NULL, '2019-04-02', 1, 1, 1, '2019-05-28', 'reham', '202cb962ac59075b964b07152d234b70', 2, NULL, 1, 10, 'ريهام.png'),
(35, 'نعمة', 'abdob2623@gmail.com334', '01114355333', 'test', NULL, '2019-05-08', 1, 1, 1, '2019-07-02', 'nemaa', '202cb962ac59075b964b07152d234b70', 2, NULL, 1, 10, NULL),
(36, 'اسماء', 'abdob2623@gmail.com4', '0111435532', 'test', NULL, '2019-02-25', 1, 1, 1, '2019-05-28', 'asmaa', '202cb962ac59075b964b07152d234b70', 3, 32, 1, 10, NULL),
(37, 'هدير', 'abdob2623@gmail.com5', '01114355323', 'test', NULL, '2019-07-09', 1, 1, NULL, '2019-08-05', 'hader', '202cb962ac59075b964b07152d234b70', 3, 32, 1, 10, NULL),
(38, 'رحمة', 'abdob2623@gmail.com66', '111435533011', 'test', NULL, '2019-04-02', 1, 1, 1, '2019-07-02', 'rahma', '202cb962ac59075b964b07152d234b70', 3, 35, 1, 10, NULL),
(39, 'عزة', 'abdob2623@gmail.com7', '01114355330111', 'test', NULL, '2010-02-02', 1, 1, 1, '2019-07-03', 'aza', '202cb962ac59075b964b07152d234b70', 3, 35, 1, 10, NULL),
(40, 'داليا', 'abdob2623@gmail.com8', '01114355330223', 'test', NULL, '2010-02-02', 1, 1, 1, '2019-01-29', 'dalya', '202cb962ac59075b964b07152d234b70', 3, 35, 1, 10, NULL),
(42, 'testAdministrative', 'abdob2623@gmail.com221', '01114355330', 'test', NULL, '2010-02-02', 1, 1, 1, '2019-08-27', 'Administrative', '202cb962ac59075b964b07152d234b70', 4, 32, 1, 10, NULL);

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
(1, 3, '0000-00-00 00:00:00', '2019-10-01 06:10:14', 1),
(5, 32, '0000-00-00 00:00:00', '2019-10-01 05:46:32', 2),
(6, 33, '0000-00-00 00:00:00', '2019-10-01 06:10:10', 1),
(7, 36, '0000-00-00 00:00:00', '2019-09-17 15:50:17', 2),
(8, 39, '0000-00-00 00:00:00', '2019-10-01 00:55:50', 2),
(9, 40, '0000-00-00 00:00:00', '2019-09-17 18:18:29', 2),
(10, 35, '0000-00-00 00:00:00', '2019-09-18 17:27:06', 2),
(11, 42, '0000-00-00 00:00:00', '2019-09-22 17:55:35', 2);

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
(381, 32, '01', 0),
(382, 32, '02', 0),
(383, 32, '03', 0),
(384, 32, '04', 0),
(385, 32, '05', 0),
(386, 32, '06', 0),
(387, 32, '07', 0),
(388, 32, '08', 0),
(389, 32, '09', 0),
(390, 32, '10', 0),
(391, 32, '11', 0),
(396, 33, '01', 0),
(397, 33, '02', 0),
(398, 33, '03', 0),
(399, 33, '04', 0),
(400, 33, '05', 0),
(401, 33, '06', 0),
(402, 33, '07', 0),
(403, 33, '08', 0),
(404, 33, '09', 0),
(405, 33, '10', 0),
(406, 33, '11', 0),
(407, 34, '01', 0),
(408, 34, '02', 0),
(409, 34, '03', 0),
(410, 34, '04', 0),
(411, 34, '05', 0),
(412, 34, '06', 0),
(413, 34, '07', 0),
(414, 34, '08', 0),
(415, 34, '09', 0),
(416, 34, '10', 0),
(417, 34, '11', 0),
(422, 35, '01', 0),
(423, 35, '02', 0),
(424, 35, '03', 0),
(425, 35, '04', 0),
(426, 35, '05', 0),
(427, 35, '06', 0),
(428, 35, '07', 0),
(429, 35, '08', 0),
(430, 35, '09', 0),
(431, 35, '10', 0),
(432, 35, '11', 0),
(437, 36, '01', 0),
(438, 36, '02', 0),
(439, 36, '03', 0),
(440, 36, '04', 0),
(441, 36, '05', 0),
(442, 36, '06', 0),
(443, 36, '07', 0),
(444, 36, '08', 0),
(445, 36, '09', 0),
(446, 36, '10', 0),
(447, 36, '11', 0),
(452, 37, '01', 0),
(453, 37, '02', 0),
(454, 37, '03', 0),
(455, 37, '04', 0),
(456, 37, '05', 0),
(457, 37, '06', 0),
(458, 37, '07', 0),
(459, 37, '08', 0),
(460, 37, '09', 0),
(461, 37, '10', 0),
(462, 37, '11', 0),
(467, 38, '01', 0),
(468, 38, '02', 0),
(469, 38, '03', 0),
(470, 38, '04', 0),
(471, 38, '05', 0),
(472, 38, '06', 0),
(473, 38, '07', 0),
(474, 38, '08', 0),
(475, 38, '09', 0),
(476, 38, '10', 0),
(477, 38, '11', 0),
(482, 39, '01', 0),
(483, 39, '02', 0),
(484, 39, '03', 0),
(485, 39, '04', 0),
(486, 39, '05', 0),
(487, 39, '06', 0),
(488, 39, '07', 0),
(489, 39, '08', 0),
(490, 39, '09', 0),
(491, 39, '10', 0),
(492, 39, '11', 0),
(497, 40, '01', 0),
(498, 40, '02', 0),
(499, 40, '03', 0),
(500, 40, '04', 0),
(501, 40, '05', 0),
(502, 40, '06', 0),
(503, 40, '07', 0),
(504, 40, '08', 0),
(505, 40, '09', 0),
(506, 40, '10', 0),
(507, 40, '11', 0),
(523, 42, '01', 0),
(524, 42, '02', 0),
(525, 42, '03', 0),
(526, 42, '04', 0),
(527, 42, '05', 0),
(528, 42, '06', 0),
(529, 42, '07', 0),
(530, 42, '08', 0),
(531, 42, '09', 0),
(532, 42, '10', 0),
(533, 42, '11', 0);

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
(1, 3, 'علي حمدان محمد حمدان', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'LLM Student', NULL, 'aiy_hemdan2009@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(2, 3, 'ايام انا دودا وبنعشها', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Bc in business adm.', NULL, 'dsdsds455@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(3, 3, 'Basem Atef', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'رجل اعمال', NULL, 'tito_tito66014@gahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(4, 3, 'Ahmed Eid', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'رقيب', NULL, 'ahmedshebl22@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(5, 3, 'محمود اسامه محمود', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'الكنترول', NULL, 'mahmoudosama00@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(6, 3, 'Mahmoud Eldsoke', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Associate director', NULL, 'mahmoudeldesoky717@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(7, 3, 'احمد محمد انور البنداري', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Managing Partner', NULL, 'abendary@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(8, 3, 'Fathy Elaboudy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس', NULL, 'fffa244@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(9, 3, 'حسام فوزى عبد العزيز', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'retired employee', NULL, 'hossamfawz4497@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(10, 3, 'هاني ابو منه', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'تسويق الكتروني', NULL, 'abwmnh677@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(11, 3, 'اشرف مختار', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظفه', NULL, 'mo_33_mo@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(12, 3, 'Hema Hema', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'government employee', NULL, 'hhema382@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(13, 3, 'بدر الدولى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Student', NULL, 'badr_badr7@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(14, 3, 'علاء أحمد محمد حمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ا.اميره فليفل', NULL, 'alaahmad4675@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(15, 3, 'Seka Eltofan', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'رئيس مهندسين اقدم', NULL, 'fox_soso40@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(16, 3, 'Walid Yussef', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'm', NULL, 'wledommar@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(17, 3, 'Tarek Saied', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف', NULL, 'rahafsd@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(18, 3, 'مجدى مجدى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدرس', NULL, 'magdy_magdymagdy@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(19, 3, 'احمد حسن محمد حسين', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Mechanicl Engneer', NULL, 'abc_abc571@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(20, 3, 'فليمون عدلي لويز', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اداري', NULL, 'philooflafelo@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(21, 3, 'Ramy Eldashty', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس برمجيات', NULL, 'ramy.eldashty@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(22, 3, 'احمد عابد حسن السيد وهدان', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Crisses Managment', NULL, 'ahmedwahdan85@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(23, 3, 'Emad Syam', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدرس', NULL, 'mona.essa56@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(24, 3, 'أيمن مصطفي برهام', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ناشط ة في مجال حقوق الانسان', NULL, 'kemoov@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(25, 3, 'Osama Mahran', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'أعمال حره هندسه مدنيه', NULL, 'osamaosamaosama220@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(26, 3, 'Eslam Fooly', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'إداره اعمال الشركه', NULL, 'eslam_f19@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(27, 3, 'Hader Maged', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'معلمة', NULL, 'hader.maged.a@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(28, 3, 'Mohamed Ibrahim Kamel', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'نزار الهجرسي', NULL, 'Mohamednachintn@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(29, 3, 'Medhat Ramadan', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اعلامي', NULL, 'abo.kadi84@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(30, 3, 'UCant OwnMe', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'بكلويوس قانون', NULL, 'tarekrivaldo2000@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(31, 3, 'Nader Kamal', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'هندسه مدينه', NULL, 'nader_kimo2050@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(32, 3, 'Marco Megally Lale', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Chemical Engineer', NULL, 'marcolale@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(33, 3, 'Eng Sarah Ibrahim', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مرشدة طلابية', NULL, 'sarah_ibrahim9010@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(34, 3, 'محمد عصمت عبدالمنعم', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'استاذ', NULL, 'mohamd@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(35, 3, 'Alaa Hikal', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'national technical advisor', NULL, 'alaa141062alaa@gmil.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(36, 3, 'Ahmed Elkady', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مندوب مبيعات', NULL, 'ahmed_sobhy123456@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(37, 3, 'Reda Omeira', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف اداري', NULL, 'Omeirareda@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(38, 3, 'Basem Farouk', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Manager', NULL, 'basemfarok37@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(39, 3, 'عمرو مجدى فتحى عبده حمزه', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ادارة اعمال', NULL, 'amr.hamza37@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(40, 3, 'Mahmoud Elashre', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ممهندس', NULL, 'mahmoudelashre640@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(41, 3, 'Gehan Osman', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'حفار ابار مياه جوفيه', NULL, 'gehanosman760@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(42, 3, 'Môhãmêd Dãhßhâñ', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'HR', NULL, 'mohamed2dahshan@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(43, 3, 'Hamada Mahros Abo Gabl', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ادارة', NULL, 'motta_style@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(44, 3, 'أيهاب منصور أيهاب منصور', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محامي', NULL, 'ehabmansour65@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(45, 3, 'عزالدين مكرم صديق حسن', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'International Business Consultant', NULL, 'Ezzair333@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(46, 3, 'Houda Hassan', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'عضو فني جودة تعليم', NULL, 'h_mahmooud@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(47, 3, 'Amged Ahmed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Volunteering', NULL, 'amged.ahmed888@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(48, 3, 'Amor Elamoor', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'own business', NULL, 'asd.amr48@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(49, 3, 'لمياء إبراهيم رشوان', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اداره اعمال', NULL, 'marwaokasha@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(50, 3, 'فايز مرسى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Businessperson', NULL, 'aboyousef941@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(51, 3, 'Medhat Nagy El Nagy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'نظم معلومات اداريه', NULL, 'medhatz_agram@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(52, 3, 'الصلاة على النبى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'manger computer', NULL, 'mahasaad23@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(53, 3, 'Mohammed Asfour', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Lecturer', NULL, 'asfourlove98@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(54, 3, 'أميرالسيدعبدالنطلب ابوالخير', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'عامل الحرية', NULL, 'abosalma_net@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(55, 3, 'Samir Sabry', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ادارة المراجعة المالية', NULL, 'sm_sm_82@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(56, 3, 'سمر ياسر عبد اللطيف', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مشاريع الهيئة', NULL, 'samarf16@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(57, 3, 'zakaria tarek mohamed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'لا اعمل', NULL, 'torky_22000@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(58, 3, 'Mahmood Al-dulaimi', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Product Manager', NULL, 'm_shhab@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(59, 3, 'Ahmed Sedky Elzanaty', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'D.M.', NULL, 'Ahmed.elzanaty83@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(60, 3, 'كارم محمود محمد المصرى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مسؤال علاقات عامه', NULL, 'karamelmasry@gimal.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(61, 3, 'Hany Shahein', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'رئيس ملاحظين', NULL, 'top2fiber@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(62, 3, 'Yasser Sayd', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Nothing', NULL, 'yasser.sayd@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(63, 3, 'ياسر احمد السيد احمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'executive secertary', NULL, 'ahmed.yasser572@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(64, 3, 'محمد رجب البروكي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Assistent Engineer', NULL, 'mmrr719@gamil.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(65, 3, 'احمد محمد سيد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'bachlor of physics', NULL, 'qanasalwa89@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(66, 3, 'Soad Rageh', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'لايوجد', NULL, 'sososer.22@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(67, 3, 'Ibrahim mohammed saad hirby', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدرس', NULL, 'ibrahim.hirby@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(68, 3, 'Farhat Alaebaidy Mohammed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ناشط شبابي', NULL, 'farhatmohamed74@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(69, 3, 'احمد عزالدين حسن', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'عليه محمد مهوس', NULL, 'ahmed_ezz_ezz@live.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(70, 3, 'Ramiz Yossef', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'RT', NULL, 'mizoo_mozaa@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(71, 3, 'موسى فتح الله كريم عبدالعال', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اداري', NULL, 'anamoaz153@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(72, 3, 'Ahmed Ibraheem', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'صيدلية التأمين الحى', NULL, 'ahmed.ibraheem93@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(73, 3, 'Mohamed mahmoud', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالبه', NULL, 'modydanger@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(74, 3, 'احمد سمير السيد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مرشد سياحي', NULL, 'ahmedsamir808@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(75, 3, 'هاني موريس', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اداره اعمال', NULL, 'jloveme30@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(76, 3, 'abduallah ismail', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Jordan', NULL, 'abduallah_mohammed@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(77, 3, 'Basem Helmy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Branch Manager Pizza Hut in Saudi Arabia', NULL, 'basem7elmy@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(78, 3, 'Mahmoud Elshrnoby', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'chef', NULL, 'mm_elshrnoby@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(79, 3, 'علي محمد محمد عبد العزيز', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Organizational things', NULL, 'wwwwwww4568@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(80, 3, 'Mohamed Mahmoud', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'احصائي', NULL, 'memo_2022l@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(81, 3, 'محمد البحيری', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير أقدم', NULL, 'mido_tiger3073@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(82, 3, 'أّبِوِبكرعٌبِدِأّلَنِبِيِّ مَحٌمَدِعٌلَيِّ زغاليل', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ادارة اعمال', NULL, 'abobkr_love46@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(83, 3, 'مہصہريہ شہيہكہ', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محامى', NULL, 'alaaeslam421@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(84, 3, 'Mahmoud Abd El Rahman', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Civil Engineer', NULL, 'anaelmajic200@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(85, 3, 'على مصطفى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'إلإدارة مالية و المصرفية', NULL, 'a01010094123@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(86, 3, 'Amal Ahmed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'بكالوريوس ادارة اعمال', NULL, 'molaeng84@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(87, 3, 'Mouhamed Mohsen', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Sr. Supervisor', NULL, 'mouhamedmohsen92@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(88, 3, 'عمر قدرى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'الشركة العامة لإدارة النقل الخاص', NULL, 'kadryo088@gmil.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(89, 3, 'Mohamed Ali Mohamed Ali Elsaeidy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'forman', NULL, 'engineer.emg2@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(90, 3, 'Hassan Mohamed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Secretary', NULL, 'hassan.mohamed3040@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(91, 3, 'Ôshà Ôshâ', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير تنفيذي', NULL, 'sh.adel18@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(92, 3, 'صبحي فراح احمد حرب', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالبه', NULL, 'sobhy.harb@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(93, 3, 'محمد الدكروني', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدربة تنمية بشرية', NULL, 'mohamedmidoo473@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(94, 3, 'حودة الرماح', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'University Professor', NULL, 'nadaahmed5066@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(95, 3, 'Mohamed Figo', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'استشاري مبيعات', NULL, 'figo_figo7333@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(96, 3, 'محمد عبد الخالق', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'accountant', NULL, 'abd_elkhalek85@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(97, 3, 'Osama Hassan', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاسب اقدم', NULL, 'osamamano13@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(98, 3, 'Dode Idrees', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'لا اعمل', NULL, 'daliadod35@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(99, 3, 'Adel Ashmawy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Pharmacist', NULL, 'AdelAshmawy3302@gamil.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(100, 3, 'islam gamal el-Den saad ali', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'رئسية وحدة ادخال', NULL, 'jaguerpaw25@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(101, 3, 'آبو شهد عبدة العشماوي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Designer', NULL, 'mr444555@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(102, 3, 'Mido Mostafa', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'teacher', NULL, 'mohamed_love8206@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(103, 3, 'على أبو على', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مستشار مالي', NULL, 'mr_ali90@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(104, 3, 'عبد الحميدمحمد عبدالحليم احمد بدر الديب', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'صاحب الشركة', NULL, 'amedo2226@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(105, 3, 'Moamen Mohamed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ممرض', NULL, 'hemamomen@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(106, 3, 'هانى عبدالعزيز عطعوط', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مكتب المراقب المالي', NULL, 'hanyabdelaziz81@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(107, 3, 'جاد جاد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالب', NULL, 'gadgad689@gimal.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(108, 3, 'ابراهيم عبدالرحمن محمد مصطفي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'صاحب مؤسسة تجارية', NULL, 'ibrahim.miligy.86@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(109, 3, 'مصطفى محمد مهران', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير تدقيق اقدم', NULL, 'mostafa.mohran@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(110, 3, 'Mohamed fathy ahmed mohamed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Office manager', NULL, 'assetsco@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(111, 3, 'احمد البحيري', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ادارة اعمال', NULL, 'aelbhery50@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(112, 3, 'Hisham Yousef', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'occupational therapist', NULL, 'hisham_yousef@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(113, 3, 'Ramy Saad', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير', NULL, 'ramysaad1234@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(114, 3, 'Mido King', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظفة . محاسبة', NULL, 'midoking1155@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(115, 3, 'Marwa Abdallah', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'رئيس وزراء سابقآ', NULL, 'loka_com2000@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(116, 3, 'اشرف كدوانى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'mihamed', NULL, 'kedwany2@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(117, 3, 'Mahmoud sobhi saif elnasr', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاسبة', NULL, 'mah_saif.2010@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(118, 3, 'Mohamed Samir Eissa', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف اداري بالشركة العامة للكهرباء', NULL, 'm.samir5890@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(119, 3, 'Hossam Ramzy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اداره صيانه', NULL, 'hero.lovers@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(120, 3, 'Magda Abdo', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'MBA', NULL, 'magdaabdo72@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(121, 3, 'محمد شكر', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'استاذ ثانوي', NULL, 'mohamedshokr88@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(122, 3, 'Mohammed Ibrahim', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'District Manager', NULL, 'mohammedbon1989@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(123, 3, 'Mostafa Marey', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ربة منزل', NULL, 'mostafa.marey@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(124, 3, 'مصطفى محمد مصدق', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Prisedent', NULL, 'dream_x87@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(125, 3, 'بتقول تعبتك ادينى سبتك', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'pharmacist', NULL, 'badrmohamd478@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(126, 3, 'Shereen Abdelgwad', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Graduate Assistant', NULL, 'shereens628@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(127, 3, 'Ahmed khalaf mohamed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاضر', NULL, 'Wineergroup6@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(128, 3, 'Wael Ramdan', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاسب', NULL, 'waelramdan53@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(129, 3, 'ميرو شلبي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Petroleum Engineer', NULL, 'mahershalpy@Yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(130, 3, 'Roaa Amar', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'خريجة كلية تربية قسم لغة إنجليزية', NULL, 'bosekat14@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(131, 3, 'محمد حسين', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'خريج', NULL, 'drmody292@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(132, 3, 'كرم عبده', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مندوب مبيعات', NULL, 'karamapdo2020@gmile.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(133, 3, 'احمد عادل معوض فراج', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'eng', NULL, 'ahmed.adelfarag@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(134, 3, 'Osama Ibra Him', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس سوفت + هارد وير هواتف نقالة', NULL, 'usama_shaban@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(135, 3, 'وفاء عبد المنعم عبد الفتاح شهاب الدين', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف', NULL, 'wafaa3698@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(136, 3, 'امين زكريا امين عيد الشال', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ادارة اعمال', NULL, 'mhmodei@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(137, 3, 'Mohamed Ali', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Administration manager', NULL, 'Mohamed.113976@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(138, 3, 'السيد شويل', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'projects manager', NULL, 'abo.ammar2014@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(139, 3, 'عبد السميع عطيه عبد السميع', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مديره المركز وخبيره التجميل', NULL, 'abdo.atia17@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(140, 3, 'زهرة العلا', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'رئيس تحرير مجلة الحلم الجديد', NULL, 'ola_198040@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(141, 3, 'Ghada Elshabrawy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'صرافه', NULL, 'prensses.2011@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(142, 3, 'Mostafa mohsen Mustafa', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالب', NULL, 'mostafamsasa45@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(143, 3, 'احمد خيري محمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Project Manager', NULL, 'ahmed.almakawe@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(144, 3, 'Mohamed Fathy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير عام الشركة', NULL, 'm.a.fathy@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(145, 3, 'Mostafa Nabih', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'رئيس ملاحظين', NULL, 'sasa22_2009@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(146, 3, 'اسير العيون اسير العيون', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير اعمال', NULL, 'totalove201048@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(147, 3, 'محمد جمال قاسم عبد الرازق شليوة', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف حكومي', NULL, 'ali277@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(148, 3, 'Al Lourd', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدرس', NULL, 'legaladvisor02@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(149, 3, 'Ahmed Shohaib', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مستشار تحكيم دولي', NULL, 'drbka_88@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(150, 3, 'Abeer Yousef Ismael', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'استاذ ه رياضيات', NULL, 'yabeer666@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(151, 3, 'الحاج حسن المقدم', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'كاسب', NULL, 'hassn_100035@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(152, 3, 'منتصر الشاهيني لعبيدي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مسؤول شعبة', NULL, 'egmontaser@g.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(153, 3, 'عماد حمدي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير حسابات', NULL, 'emadhamdi95@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(154, 3, 'Sayed Mohammed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس مشرف عام ميكانيكي', NULL, 'sayed.mohammed61@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(155, 3, 'Ahmed Mokhtar Mokh', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اداراة اعمال', NULL, 'helm.hayate@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(156, 3, 'محمود احمد اسماعيل', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير فني اقدم', NULL, 'bebolove202060@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(157, 3, 'مهنى عبدالعاطى مهنى أحمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ngner', NULL, 'mehani@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(158, 3, 'Mohamed Salem', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اختصاصي تسويق', NULL, 'vip_prosecutre@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(159, 3, 'Ayman Awny', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير ادارة الدراسات والقروض', NULL, 'aymanresat@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(160, 3, 'رضا ووشو', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالب ثم مدرس', NULL, 'r_woosho_1977@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(161, 3, 'Sherif Saad Elghrib', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'شباب فى حب مصر', NULL, 'sherifsaad3000@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(162, 3, 'عادل خليل عيد سليمان', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'المتحدث الرسمي والمنسق والمدير العام لشركه', NULL, 'adl_khalil@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(163, 3, 'Hassan Khalaf', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Chef', NULL, 'hassankhalaf78@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(164, 3, 'Lolo Katy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اخصاءي تسويق', NULL, 'lolo_katy@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(165, 3, 'حسام محمد عنتر', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Engineer', NULL, 'h.elraa@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(166, 3, 'Nady Antr Adm', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Accountant', NULL, 'hhss.nady@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(167, 3, 'Amr Abdelazem Kholief', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ماجستير تربة', NULL, 'kholief_amr@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(168, 3, 'Mohamed Elrwdy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'معلم', NULL, 'elrwdy3@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(169, 3, 'ابو ياسين', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'دبلوم هندسه', NULL, 'sr_love11@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(170, 3, 'هانى ابودراهم المعازي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مندوب بيع', NULL, 'hanidrahim@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(171, 3, 'محمد يحيى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مندوب مبيعات', NULL, 'mohmed.yhya1@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(172, 3, 'احمد عبد المقصود احمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Business executive', NULL, 'aelbasha177@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(173, 3, 'احمد دياب', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاسب', NULL, 'ga_sun21@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(174, 3, 'احمد عادلي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Teacher', NULL, 'ahmedadely10@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(175, 3, 'Hamada Hamada Gh', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'civil engineer', NULL, 'hamadagh75@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(176, 3, 'Aeng Ahmed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس', NULL, 'ahmedibrahim46@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(177, 3, 'Anwer Hesham', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالب', NULL, 'anwarkzalek@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(178, 3, 'Mahmoud  Massoud Aboelsaad', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Teacher', NULL, 'maboelsaad@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(179, 3, 'Mohamed Hossam Alamrkany', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Cda', NULL, 'tigerdragin1210@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(180, 3, 'Ali suliman', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اخصائي اول بصريات', NULL, 'alysuliman0@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(181, 3, 'Ahmed Attalla', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'عمل خاص', NULL, 'ahmedattalla8888@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(182, 3, 'Μõhãmêđ Ašhräf', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اداره اعمال', NULL, 'misho_love_love201314@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(183, 3, 'حسين امير محمد صلاح الدين', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Engineer', NULL, 'h.hssen40@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(184, 3, 'Tony Nagy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'manjer', NULL, 'tonynagy2020@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(185, 3, 'انا حبيبة بابتي انا', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاسبه', NULL, 'myasmen354@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(186, 3, 'Abd EL-Rahman Okasha', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Business Man', NULL, 'hamenyokasha@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(187, 3, 'mohamed amr salah', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مديرمبيعات', NULL, 'devil_1500_50@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(188, 3, 'Sayed Ashraf', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'mahdi', NULL, 'shref.wener@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(189, 3, 'Ahmed Amir', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير موقع مستشفى', NULL, 'ahmedamier88@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(190, 3, 'Marawan Elmarasy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مساعد مدير إدارة العمليات المحليه', NULL, 'marawan-elmarasy@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(191, 3, 'Fahd Ahmed Alrian', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ﻻ أعمل', NULL, 'fahdalrian1@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(192, 3, 'Amel Farouk', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'إداري', NULL, 'amelsasa9@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(193, 3, 'Mahmoud Seda', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'إدارة أعمال', NULL, 'mahmoudseda1@gamil.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(194, 3, 'Mahmoud Fayed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مساعد امين مستودع', NULL, 'fayed103@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(195, 3, 'محمد عبد المعبود', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'تجارة عامة', NULL, 'apdo_ma@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(196, 3, 'محمد احمد منصور', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'حداد', NULL, 'bassbass108@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(197, 3, 'Yasmine Elzwawy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدقق', NULL, 'yasmineelzawawy@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(198, 3, 'Mido W Mido', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'translation', NULL, 'medo_hamada20000@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(199, 3, 'وثقت بربى فلن يخذلنى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس كمبيوتر', NULL, 'mego2512015@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(200, 3, 'مؤمن محسن عبدالغنى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'دراسة اعمال', NULL, 'moamn.elol@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(201, 3, 'ابانوب نبيل', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'صراف', NULL, 'benonabil84@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(202, 3, 'Khaled Noby', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موطف في الحومه', NULL, 'khalednoby885@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(203, 3, 'احمد يوسف', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Graduater senior student', NULL, 'ahmeduosef_2010@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(204, 3, 'احمد الامير المحامى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير اقليمي', NULL, 'timoor2010_ahmed@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(205, 3, 'Samer Soliman', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'bacalorios health adminstration', NULL, 'eltomygroup@icloud.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(206, 3, 'عمرو محمد جابر سليمان', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مسؤله قسم', NULL, 'a.mr20023@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(207, 3, 'John Mohsen', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ممرضه', NULL, 'jojo_dj45@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(208, 3, 'ريتاج جعفر', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اداره اعمال', NULL, 'memegafar2@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(209, 3, 'Mohamed Elgamel', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالب', NULL, 'kapoooo99@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(210, 3, 'ايمي ابراهيم احمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Software Engineer', NULL, 'moany-20013@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(211, 3, 'Ahmed Elhelali', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'كلية فنون جميلة', NULL, 'mido_miro710@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(212, 3, 'Ataa Araby', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهند', NULL, 'rouqa_rouqia@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(213, 3, 'Eslam Osman', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'office Secretary', NULL, 'eslamosman202@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(214, 3, 'يسرى عرابى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'كتور صيدلئ', NULL, 'yuossrioraby@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(215, 3, 'Ahmed Gabr', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'pharmacist', NULL, 'ahmedgabr1212@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(216, 3, 'أحمد عبده', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'دبلوم عالي محاسبه', NULL, 'ahmed.642010@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(217, 3, 'Dr-yahia Shalaby', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Studying engineer', NULL, 'Dr.yahiashalaby@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(218, 3, 'Ahmed Mahmoud', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مستشار قانوني واداري', NULL, 'ka3bool50@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(219, 3, 'Ana Nada', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'معلمه', NULL, 'nonahelmy55@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(220, 3, 'Essmat Abdel Zaher', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Central Risk Manager', NULL, 'essmatmoh@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(221, 3, 'محمد ابراهيم عسليه', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Owner', NULL, 'mohamedassalya22@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(222, 3, 'Mahmoud A Mahmoud', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ادارة الامن', NULL, 'mesraa513@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(223, 3, 'Mohamed Samir', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اعلامي', NULL, 'elporsaedy@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(224, 3, 'Ayman Ezz Ezz', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Financial Manager', NULL, 'tamer8008@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(225, 3, 'Omeil Tharwat', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طبيب بشرى', NULL, 'omeilsarwat@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(226, 3, 'علاء سعيد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مصمم', NULL, 'salaa3564@gmali.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(227, 3, 'Mohamed Ezz', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Businessperson', NULL, 'zaza_180@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(228, 3, 'العمده ياسر عز مراد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'English Teacher', NULL, 'yasser.2141980@jmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(229, 3, 'رضاكمال احمد زيدان', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Civil Engineer', NULL, 'redakamal2011@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(230, 3, 'Radi ahmed hamouda', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف', NULL, 'radiahmed57@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(231, 3, 'Amir Ebrahem', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'المدير التنفيذي بمصنع المائدة الاصيلة للصناعات الغذائية', NULL, 'mero_xp_2013@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(232, 3, 'Wael Arafa', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاسب', NULL, 'wael_arafa2005@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(233, 3, 'Ahmed Saed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مكتب', NULL, 'ahmedmemo202@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(234, 3, 'أشرف عبدالرحيم أبوزيد القهوجى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اقتصاد', NULL, 'abodiaa_73@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(235, 3, 'Mayer Mohsen', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مندوب', NULL, 'Mayer.tawadrous@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(236, 3, 'Kamel ahmed kamel', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'متخرجه من بكالوريوس اقتصاد', NULL, 'kemocut12@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(237, 3, 'سعيد محمود', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'engineer', NULL, 'mahm0udsaad2015@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(238, 3, 'احمد محمد السيد مرواد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'نائب مدير ادارة', NULL, 'romio200820002002@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(239, 3, 'Mohamed Mohsen', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'معاون مدير حسابات', NULL, 'mohamed_medo01@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(240, 3, 'ممدوح رجاءى رضوان محمدالسعودى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'hr', NULL, 'mamdouhragaey3@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(241, 3, 'Beshoy Nagy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف إدارى بوزراه التربيه والتعليم', NULL, 'vetox200@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(242, 3, 'Mohamed Turki', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مشرف مبيعات', NULL, 'mohamed_turki3@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(243, 3, 'ماجد عتمان', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ال', NULL, 'faresfahd99@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(244, 3, 'Ahmed Mohamed elhofy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'حسابات', NULL, 'elshafra_3@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(245, 3, 'Mohamed Elhady', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'م.مديرمخازن', NULL, 'melhade54@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(246, 3, 'Mahmoud Sharawy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'تجارة حرة', NULL, 'sharawy3030@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(247, 3, 'Adel Mohamed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'district manager', NULL, 'm_mohamed5555522@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(248, 3, 'صالح الكاشف', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مشرف اطقم ضييافة جوية دبلوم عالي ادارؤ اعمال', NULL, 'aaboahmed21@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(249, 3, 'Karim Eldeep', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف إدارى', NULL, 'karimeldeep84@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(250, 3, 'نبيل أحمد سلامة على', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدرس احياء', NULL, 'abogabal8@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(251, 3, 'mahmoud mohamed metwally', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مختبرات طيية', NULL, 'mago.mago18@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(252, 3, 'محمود المصرى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالبه', NULL, 'hoda_m202014@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(253, 3, 'كيمو راضى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'لبنان', NULL, 'kimo200682@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(254, 3, 'Abdo Alraig', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير. شركه أصلان وشركاه للاسكان والاستثمار', NULL, 'mwo16@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(255, 3, 'طارق لطفي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالب', NULL, 'tareklotfy142@Yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(256, 3, 'Ahmed Hussien', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مبرمج', NULL, 'ahmedhassun444@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(257, 3, 'جبار الاسدي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'عمل حر', NULL, 'jabar_zain@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(258, 3, 'وائل محمد فتحي حبيش', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Shelter Project Manager - South', NULL, 'waelbishoo7@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(259, 3, 'احمد الشبح', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالب', NULL, 'aa698667@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(260, 3, 'Saed Nsr', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'hr', NULL, 'saed.pop356@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(261, 3, 'Samy Teleb', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'دبلوماسي', NULL, 'samyteleb570@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(262, 3, 'صبري محمد مصطفى عطيه', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'doctor', NULL, 'sabrysoliman@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(263, 3, 'Mostafa Ahmed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Secretaria', NULL, 'momr417@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(264, 3, 'Ahmed Mahmoued', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Hello', NULL, 'ahmedtitio2020@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(265, 3, 'Môĥâmeď Hāgāģ', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'شركة تصدير واستيراد', NULL, 'mohamedhagagg11@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(266, 3, 'وائل اسماعيل', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'radiology', NULL, 't.2090@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(267, 3, 'Ahmed El Sawy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Vice President', NULL, 'hamadaelsawy99@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(268, 3, 'DrAhmed Maher', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف', NULL, 'maher_a69@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(269, 3, 'عمر خالد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ربة بيت', NULL, 'adballah33381@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(270, 3, 'مجدى ثابت فهمي حبشي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Educational Psychologist', NULL, 'magdyhapashy@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49');
INSERT INTO `customercrm` (`customerCrmId`, `addedby`, `customerCrmName`, `customerCrmPhone`, `customerCrmSecondPhone`, `customerCrmEmail`, `customerCrmCompany`, `customerCrmGov`, `customerCrmJob`, `customerCrmQualification`, `customerCrmCountry`, `customerCrmAddress`, `customerCrmAge`, `customerCrmGender`, `customerCrmActivity`, `customerCrmOther`, `customerCrmCreateDate`) VALUES
(271, 3, 'Eslam Eladawy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'teatcher', NULL, 'almarede@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(272, 3, 'امين طاهر نبهان', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدرس', NULL, 'amin_norin_2@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(273, 3, 'حلم العمر', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس.معدات طبيه', NULL, 'abohnyn@yaho.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(274, 3, 'أسماء القيصر', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اداره اعمال', NULL, 'asmaa.elshamy01116@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(275, 3, 'محمود جيدو', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Doctor', NULL, 'ss_ww106@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(276, 3, 'Hussein Teka', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محلسب', NULL, 'hussein_teka@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(277, 3, 'Leto Alex', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مشروعات', NULL, 'dragoon_2009@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(278, 3, 'Abduallah Gafar', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مبرمج', NULL, 'beibo_13@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(279, 3, 'محمد عبدالمتعال محمود محمد عبدالله', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'بكالوريوس اداب', NULL, 'amoor.yosif@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(280, 3, 'احمد الليثى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'معلمة قرآن', NULL, 'shehab.soha@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(281, 3, 'Mohamed Ali Ram', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'كلية طب الأسنان', NULL, 'medo000777@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(282, 3, 'على السيد مجاهد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Security Engineer', NULL, 'prof_megahed@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(283, 3, 'Mostafa Ezzat abdel slam Ahmad', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف في تربية قضاء دهوك', NULL, 'kranshymostafa@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(284, 3, 'Hassan Ghazy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مخازن', NULL, 'hassanghazy78@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(285, 3, 'Mohammed Barakat', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مالي', NULL, 'mohamed.adel.barakat.87@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(286, 3, 'Reem Waheed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'customer  service', NULL, 'ronahazim1996@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(287, 3, 'Ahmed Rami', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'رئيس المنظمة', NULL, 'ramimagk@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(288, 3, 'Sayed Salem', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'planning Engineer', NULL, 'sayedsalem34@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(289, 3, 'Ehaab Abdala aly', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Architect', NULL, 'ehaaab5@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(290, 3, 'Jana Mohmed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'امين صندوق', NULL, 'l2mis_2011@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(291, 3, 'خميس محمد حسن مصطفى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس مدني', NULL, 'maryam7781@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(292, 3, 'Shabanshmed Rdyin', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'عمل حر. تجارة', NULL, 'errr5781@mail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(293, 3, 'نسمه وكلمه', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Storekeper', NULL, 'sanaaahmed594@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(294, 3, 'كريم احمد علي اسماعيل', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالب', NULL, 'karemfox19@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(295, 3, 'ﻣﻮﺳﻲ ﺍﻟﻔﻘﻲ', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Goverment Job', NULL, 'mmossuaposs@gamil.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(296, 3, 'Waled Pop', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'GM', NULL, 'waledpoppopwaled@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(297, 3, 'Badr Mazeka', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'student universtaye', NULL, 'mm5032@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(298, 3, 'محمد فتحى أحمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير عام', NULL, 'mmfat7e@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(299, 3, 'عبدالله البدري احمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ربة منزل', NULL, 'a01112344577@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(300, 3, 'الشيخ مصطفي الغرباوي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Lecturer', NULL, 'mostafa.elgahrbawy@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(301, 3, 'Walid Allam', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مشتريات', NULL, 'walid.alaam@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(302, 3, 'Haysam Atef Mahmoud', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'agronomist', NULL, 'kind_heart97@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(303, 3, 'Khalf Nhael', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'officer', NULL, 'khalfnhael@windowslive.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(304, 3, 'Mohamed Said Mohamed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مسؤولة موارد بشرية وجودة', NULL, 'm.s2234@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(305, 3, 'Taher Omar', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'English language instructor', NULL, 'melonco-66@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(306, 3, 'محمد السيد محمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Director of Photography', NULL, 'medo1000_eg@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(307, 3, 'Gehad Magdy Zeid', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'دراسات', NULL, 'gehad_magdy@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(308, 3, 'رومناسى ومنسى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Marketing Director', NULL, 'wael8174@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(309, 3, 'Moahamed Elmasry', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Electronic engineer', NULL, 'mohamed_elmasry712@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(310, 3, 'Sayd Tantawy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'م.طبي/ صحة مجتمع', NULL, 'saydtantawy769@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(311, 3, 'حسن ذكى ابو خديجة', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Sales Manager - Medical Imaging Dept', NULL, 'hasan.zaky3777@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(312, 3, 'Mostafa Ahmed mohmed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس', NULL, 'mostafa_ahmed199446@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(313, 3, 'احمد جبريل', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدرس', NULL, 'ahmad.gebrel@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(314, 3, 'سهيل حماده محمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اخصائي تنميه اداريه', NULL, 'd.sohail_1phnub@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(315, 3, 'حامد محمد الوكيل', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالب جامعي', NULL, 'hamedalwekel_y_a@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(316, 3, 'Mohamed Mido', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Finance Manager', NULL, 'mohmedmido884@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(317, 3, 'Mohamed Mousa', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اقتصاد', NULL, 'mo7a002@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(318, 3, 'Īsraa MōstaFa', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'student', NULL, 'stop_love2010@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(319, 3, 'محمد حسين غنام جمعه', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Lawyer', NULL, 'mohamedhassin17@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(320, 3, 'محمد البحيري', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدرس فيزياء', NULL, 'medomedoemy82@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(321, 3, 'Moheamed Ahmed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'MEP Projects Manager', NULL, 'bosybosy3330@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(322, 3, 'د. هشام السعودي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Medical technician analyzes', NULL, 'hs6666@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(323, 3, 'moataz mohamed  mousa', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير', NULL, 'm1995@gmil.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(324, 3, 'ايهاب احمد سعد محمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مﻻح جوي', NULL, 'aboosmma@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(325, 3, 'Ahmed Ayman Shehata', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير اداره', NULL, 'ahmed_ayman1691@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(326, 3, 'Rasha fouad', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مسؤال ائتمان', NULL, 'rosha242@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(327, 3, 'Raafat Kamel', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Admin', NULL, 'raafatkameltaher.2011@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(328, 3, 'طارق عزالعرب', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'IT', NULL, 'tarekezz03@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(329, 3, 'محمد فتحي منصور عبدربه', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Doctor physiotherapy', NULL, 'mohamed_fathe53@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(330, 3, 'احمد سند', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Account officer', NULL, 'adahmedsanad@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(331, 3, 'Mohmed Ata', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Financial Accountant', NULL, 'atta_mohamed@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(332, 3, 'Mina Mohsen Soliman', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Architect &amp; project Eingeneer', NULL, 'Mena_love_ronah@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(333, 3, 'Ahmed Medo Medo', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'رجل اعمال', NULL, 'ahmedmedomedo070@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(334, 3, 'Mohamed Jamal', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مندوب', NULL, 'mg343517@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(335, 3, 'محمد المرسي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'General Manager', NULL, 'mohamed_elmorsy1983@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(336, 3, 'محمد الفخرانى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف حكومي', NULL, 'mohmed1982@ymail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(337, 3, 'Mansour Noufal', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'woner', NULL, 'aboasmaanoufal@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(338, 3, 'محمد مصطفي بخيت', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'نادل', NULL, 'medo33mm@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(339, 3, 'Mohamed Nasr', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'المدیر المفوض لشرکة بوتان للمقاولات العامة المحدودة', NULL, 'Mohamed00000nasr@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(340, 3, 'عصام فتحى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Human Resources Specialist (HR Specialist)', NULL, 'e.elhayat@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(341, 3, 'مؤمن فتح الباب محمد كامل', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير صناعي', NULL, 'sadpairdmw1@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(342, 3, 'Mahmoud Kassem', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Treasury Back Office', NULL, 'hhode10@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(343, 3, 'Ali Elbana', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Civil Engineer in Petronas carigali in iraq', NULL, 'eng_ali022@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(344, 3, 'ابراهيم احمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'بايلوجي', NULL, 'goo.oo22@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(345, 3, 'خالد مجدي إبراهيم الدواس', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'HR', NULL, 'khaledeldwss@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(346, 3, 'Belal Manchester', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس', NULL, 'belalmanshester@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(347, 3, 'ماهر حسين محمود عبد الحافظ محمد العريض', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مراجع ماهيات', NULL, 'maherhusaen@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(348, 3, 'احمد محمد حسن عبد الحليم', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Own Business', NULL, 'alarbya86@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(349, 3, 'حكايتي انا', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالب', NULL, 'zoza.mody18@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(350, 3, 'محمد احمد نور', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Pa', NULL, 'kemoo_100100@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(351, 3, 'المشتكي لله', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'أ مين', NULL, 'no.love9045@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(352, 3, 'Ahmed Fouad Elhawary', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'جريد المجتمع', NULL, 'hawaritive91@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(353, 3, 'نامن مبن', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاسب', NULL, 'noorbehoo@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(354, 3, 'Mähmøûd Ålêx', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'General Manager', NULL, 'mhmoud.love93@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(355, 3, 'Mohamed Salama', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Dentist', NULL, 'mohamedsalama790@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(356, 3, 'Abdelrhman Elgebaly', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Casual free', NULL, 'abdo88219@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(357, 3, 'Hamadaa Alshaer', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'senior supervisor logistics', NULL, 'hamada_bry@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(358, 3, 'Ahmed Sanwey', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدرس مساعد بقسم التدريب الرياضي وعلم الحركة', NULL, 'ahmedsanwey@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(359, 3, 'ßŏŋdŏk Ěł Gŏĥặřŷ', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Supervisor', NULL, 'bondokalsadat78@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(360, 3, 'باسم كرم عدلي خليل', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ceo', NULL, 'basemkarem99@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(361, 3, 'Adham Donya Reem', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'إدارية في مدرسه ثانوية', NULL, 'hegazya700@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(362, 3, 'شريف على كمال عبد العال الهوارى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'libya', NULL, '2mgroup2050@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(363, 3, 'هانى رمضان', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اخصائي تدريس', NULL, 'hanyramdan10@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(364, 3, 'كريم ماضى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'معلمة', NULL, 'kemoscout@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(365, 3, 'حسام جاب الله', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'وزارة المالية', NULL, 'ziadahmed.hossam@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(366, 3, 'Ahmed Sopih', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'م.صيدلي', NULL, 'sopih_sony@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(367, 3, 'Alaa Zakaria', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Constructin Engineer', NULL, 'alaazakaria731@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(368, 3, 'احمد عاشور', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ادارة اعمال', NULL, 'anan200200@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(369, 3, 'Mohamed EL Almane', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير عام جمعية ابداع لتطوير نظم التعليم', NULL, 'mohamedsamy1616@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(370, 3, 'Mahmoud Samy A.elhamed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس', NULL, 'mahmoud_samy_ae@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(371, 3, 'Mohamed Aboelward', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اداره اعمال', NULL, 'in.cafe@rocketmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(372, 3, 'Mahmoud Ghoneim', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Teacher English', NULL, 'mahmoudeljokr293@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(373, 3, 'احمد فايق', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاسبه', NULL, 'elkinga48@ymail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(374, 3, 'محمود ابوالطايف', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'G manager', NULL, 'mahmoudhamam2015@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(375, 3, 'Mahmoud Haroun', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'civil deveince', NULL, 'tito_20107589@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(376, 3, 'Asmaa Mahmoud mohammed sayd', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير التشغيل', NULL, 'aamo646@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(377, 3, 'Ahmed Kapo', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محام ومستشار قانوني', NULL, 'romancy_lovly10@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(378, 3, 'في اختلافنا رحمه', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Artist', NULL, 'bobo604@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(379, 3, 'محمد محمد عبدالحميد مرعى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'bridge Engineer', NULL, 'mohamed.marey5549@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(380, 3, 'MsEman Dewidar', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Business Development Manager', NULL, 'emydowidar@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(381, 3, 'Mohamed mohamed abdelmohsen', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف', NULL, 'm_mohamed211@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(382, 3, 'Ahmed Adel amin', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'CEO', NULL, 'ahmed_adel7331@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(383, 3, 'Mohamed Yehia', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس', NULL, 'mohamedyehia801@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(384, 3, 'محمد صبحى محمدغريب', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف حكومي', NULL, 'M.sbhy.0366@gMail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(385, 3, 'Eman ELgohary', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Financial &amp; Administrator Manager', NULL, 'ooso_emy2014@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(386, 3, 'محمد حسانين احمد حسانين', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'الإدارة', NULL, 'mohamedhassanin2010@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(387, 3, 'علي المصري', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مخازن', NULL, 'ali.adil693@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(388, 3, 'Islam Saeid', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مطعم', NULL, 'eslamsaed1199933@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(389, 3, 'محمد نعيم', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Supervisor', NULL, 'mohammed_na3em2010@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(390, 3, 'Ta Y Ea', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'سيدة اعمال ومدربة الحياة', NULL, 'pipo.tayaa@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(391, 3, 'Eslam Hawash', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'sales manager', NULL, 'eslam_7awash@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(392, 3, 'أمل نصار', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'engineer', NULL, 'amlnassar43@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(393, 3, 'Karim Kosba', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مالى', NULL, 'karim.2090@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(394, 3, 'أحمد داود', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ديوان محافظة نينوى', NULL, 'ahmedmassry@rocketmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(395, 3, 'Hamada Mostafa', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'laith', NULL, 'abo.trauka@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(396, 3, 'Essam Adel', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Maneger', NULL, 'essam_hhh@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(397, 3, 'AccAhmed Zanaty', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'خبيراعشاب', NULL, 'ahmed_ppo@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(398, 3, 'محمود احمد محمد حسن', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ضابط', NULL, 'mahmoudsharaky959@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(399, 3, 'Abdelhamid abbas abdelhamid', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Credit Officer', NULL, 'abdelhamidabbas276@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(400, 3, 'حوده بندق ابو ياسمين', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالب', NULL, 'a_asdasdfirstname@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(401, 3, 'Abdallah fawzy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'senior officer', NULL, 'abdo_alex202025@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(402, 3, 'Medhat Rezk', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف حكومي', NULL, 'lovelysm22.ll@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(403, 3, 'Amira Hassan Mohamed Hassan', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'trainer', NULL, 'king.lovemero@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(404, 3, 'محمود حيدر', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مكتب الخدمات الشاملة', NULL, 'areprinting@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(405, 3, 'Mohsen Gerges', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'تجاره', NULL, 'mohsen.gerges12@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(406, 3, 'عادل شفيق سعد فرج', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Jordan High School', NULL, 'romany_o@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(407, 3, 'Mohamed El Sayed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس اتصالأت', NULL, 'fast_dew2003@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(408, 3, 'محمدحمدي الانه', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'إدارة الأعمال', NULL, 'cnm021@Yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(409, 3, 'Momen Ashraf', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Data Entry', NULL, 'momenmemo205@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(410, 3, 'سامى ممدوح', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ادراة اعمال', NULL, 'samy201018@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(411, 3, 'Alsmany Fon', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالب  كلية الادارة والاقتصاد', NULL, 'Ahmedabdrhman55@gmil.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(412, 3, 'Ayman Elrewiey', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Owner-operator', NULL, 'aymonty1974@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(413, 3, 'Abdo Bahget', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'معلمة لغة انجليزية', NULL, 'yousefelnen@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(414, 3, 'منة الله فضل', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'الرقابة المالية', NULL, 'sarasalehfadl92@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(415, 3, 'Samy medhat elsayed ali abdo  Elgazar', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'لا شيئ', NULL, 'samyelgazar72@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(416, 3, 'مكرم محمد عبدالله الفقي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Key account manager', NULL, 'makramhurgada@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(417, 3, 'Khaled Abdelalem', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'sales manager', NULL, 'khaled.abooraby@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(418, 3, 'احمد عطا فارس محمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Exceutive Assistant', NULL, 'ahmad53269@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(419, 3, 'Mohamed Khaled', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'عضو هيئة تدريس بالمعهد الفنى الصناعى بقنا', NULL, 'mk01140843102@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(420, 3, 'Haitham Barakat zekry', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ادارة اعمال', NULL, 'jesusshephered@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(421, 3, 'Mohamed Morsy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس ميكانيكي', NULL, 'mohamed.morsy492@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(422, 3, 'على محمد على محمدمحمد رضوان', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Manager', NULL, 'mano_al_arb_2029@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(423, 3, 'Mohamed Elbana', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مبيعات', NULL, 'fokxfokx@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(424, 3, 'عمر صابر خميس', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Accountant', NULL, 'omersaper@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(425, 3, 'رمضان حمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس الكترونيات', NULL, 'rramadanhamad@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(426, 3, 'كرهتك يادنيا', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ادارة وقتصاد', NULL, 'mohmed.elmagek@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(427, 3, 'السيد عبدالحميد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'شؤن إدارية', NULL, 'alsydbdalhmyd551@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(428, 3, 'Mahmoued Alsony', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اخصائيه تخاطب', NULL, 'mahmoudahmed888870@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(429, 3, 'سامح منصور', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Owner', NULL, 'samhm9224@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(430, 3, 'Abo Hamza', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف', NULL, 'mm10020094@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(431, 3, 'بسام محمد سيد محمد شعبان', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندسة', NULL, 'basam_bob2002@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(432, 3, 'Nancy Mamdouh Samy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'programing', NULL, 'name_name300@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(433, 3, 'Shiko Shimo', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'gamoudi', NULL, 'shimaaahmedahmed961@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(434, 3, 'Islam Mondy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'doctor', NULL, 'islamondi@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(435, 3, 'Abo Ahmed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'سكرتارية تنفيذية', NULL, 'diaa_abdelgelel2015@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(436, 3, 'اشرف العارف الصعيدي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اعمال حرة', NULL, 'a.970@Gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(437, 3, 'Hanan Almhde', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Manger', NULL, 'alshamsnoor22@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(438, 3, 'Mohammed Mahmoud', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'account msnager', NULL, 'mohammed.mhamoud@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(439, 3, 'فارس الدين', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'business manager', NULL, 'aus_aus93@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(440, 3, 'محمود العيسوى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'physician', NULL, 'mahmoudsamara582@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(441, 3, 'حسن فتحي عبداللاه محمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف', NULL, 'hassan.hassan201423@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(442, 3, 'Zizo El Ghazzawi', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موطف اداري', NULL, 'anawadmodmen@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(443, 3, 'Eng Mohammed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'GM.', NULL, 'mohammedabd626@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(444, 3, 'شارب بيره ومخاوي اميره', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس', NULL, 'dalo713@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(445, 3, 'محمود عبدالقادر سيد أحمد محمود', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس', NULL, 'ganam_ganam79@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(446, 3, 'Mahmoud Mesbah', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'sales manager', NULL, 'sword_mah2010@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(447, 3, 'محمد جمعه متولى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'لا اعمل حاليا ولما هشتغل هقولك انت اول واحد', NULL, 'aymangomaa12@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(448, 3, 'محمد نعمان محمد نعمان أبو العز', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Engineer', NULL, 'mohamed.noman71@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(449, 3, 'Mohamed Jo', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مرشد تربوي', NULL, 'mohamedjo@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(450, 3, 'Ali Khattab', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدرس', NULL, 'alikhattab98@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(451, 3, 'Abdelrahman Elamin Hamid', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'داري', NULL, 'abdulrhmansd3@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(452, 3, 'Sam Mohamed Elfakia', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Mathematics Teacher', NULL, 'samnsagdg@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(453, 3, 'Mohamed Eldesouky Mano', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'تنقاش وحاصل علي ليسانس لغة عربية', NULL, 'modedode51@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(454, 3, 'Samir Fekry', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'دكتورة في ادارة الاعمال', NULL, 'Notenough2010@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(455, 3, 'Ashraf Awaad', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Supervisore', NULL, 'ashraf_awaad20@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(456, 3, 'Shenouda Mahrous showky', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مبيعات', NULL, 'mnashyoyo@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(457, 3, 'Abanoub Magdy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'خبير الأمراض الجلديةوأمراض الذكورة', NULL, 'abanoubmagdy12355@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(458, 3, 'Abdalaa Sabeh', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير تسويق ومحكم دولى معتمد', NULL, 'abdalaa.sabeh@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(459, 3, 'حسن السقا', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'متخرج بشهادة دبلوم عالي في مجال إدارة الأعمال', NULL, 'hassanha370@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(460, 3, 'Mohamed Elsheshtawy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اعمال حرةا', NULL, 'mohamed_sheshtawy18@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(461, 3, 'Sameh Awed', '01114355330', '', 'abdob2623@gmail.com', '', '', 'استاذ ثانوي', '', 'vandersameh@yahoo.com', '', 0, b'0', '', NULL, '2019-09-14 14:40:49'),
(462, 3, 'Joe Nagy', '01114355330', '', 'abdob2623@gmail.com', '', '', 'مهندس برمجيات', '', 'joenagy75@yahoo.com', '', 0, b'0', '', NULL, '2019-09-14 14:40:49'),
(463, 3, 'محمد بو حسين', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Certified Sales Executive', NULL, 'aaa.kh123@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(464, 3, 'محمد الجمال', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس كهرباء', NULL, 'me425817@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(465, 3, 'سمسم الجنتل', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موطف الشوؤن الادارية', NULL, 'osama1421998@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(466, 3, 'Ibrahim Nabil', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طبيب', NULL, 'ibrahim.nabil750@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(467, 3, 'احمد السعيد الجوهرى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'بكالريوس تربية', NULL, 'Ahmed.elsaeid24@Yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(468, 3, 'محمد احمد محمود', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالب', NULL, 'kasem_m59@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(469, 3, 'احمد ابومهند', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Sales Supervisor', NULL, 'mohamadking376@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(470, 3, 'Mohammed Saeed Omar', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مشرف تربوي', NULL, 'mohammedsaidomer@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(471, 3, 'Moataz Alaa', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ادارة الاعمال', NULL, 'Elkoptan.moataz@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(472, 3, 'اسامه محمد حسن احمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محامي', NULL, 'asd.2020.asd95@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(473, 3, 'Ahmed Shahin', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'English teacher', NULL, 'ahmedshahin777@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(474, 3, 'Mahmoud Abdelfatah mahmoud ghanem', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'assistant employee relation officer', NULL, 'medo_gh2006@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(475, 3, 'عبدالله على', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Doctor', NULL, 'manabdo560@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(476, 3, 'رومانى.بشارة.جاد.السيد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'صاحب شركه اجهزه كهربيه', NULL, 'romahy@16.rom.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(477, 3, 'ابراهيم احمد ابراهيم', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف حكومي', NULL, 'ebrahimroma3@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(478, 3, 'علي محمد علي حسن', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف', NULL, 'alialkomy333@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(479, 3, 'عبدالستار هاشم عبد الكريم خليفة', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'tetcher', NULL, 'www.sunpop36@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(480, 3, 'Ahmad Abolhsan', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس كمبيوتر ومحاضر', NULL, 'ahmadaboelhsan@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(481, 3, 'محمد الشربيني', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Engineer', NULL, 'mohamedsherbo22@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(482, 3, 'Islam Shaheen', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'General Supervisor', NULL, 'islam697@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(483, 3, 'كريم عصام محمود عياد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'امين مستودع', NULL, 'kimoelzaem@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(484, 3, 'ابوالشوق كادلك', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Associate Director Enterprises Development', NULL, 'mohamedshawky847@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(485, 3, 'Adel Amin', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'سكرتير', NULL, 'adelamin1968@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(486, 3, 'Seif Ashraf', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Project assisrant', NULL, 'saifashraf442@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(487, 3, 'Mostafa Ali', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Legislative Assistant', NULL, 'alaslam34000@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(488, 3, 'طارق حسنى مهدى متولى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاسب', NULL, 'tarekteko354@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(489, 3, 'Mohammed Abd Elrahem Samy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'لا رصاد الجوي', NULL, 'toson18@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(491, 3, 'الشيخ عبده أبو هلاله', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'student', NULL, 'abdoawad_1974@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(492, 3, 'Ebrahim Sabry Abdelrhman', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Product Manager', NULL, 'e_heartmagic_75@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(493, 3, 'سید کبیشہ', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Joinery manager', NULL, 'bas.said@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(494, 3, 'Nagy Ahmed ALrifhy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'فني اتصالات', NULL, 'admmnaagy@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(495, 3, 'مصطفى محمد محمود مصطفى غنيم', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس كيمياءي', NULL, 'mostafaghoniem@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(496, 3, 'ايمن زلط', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'فنان تشكيلي... منسق الفنون البصرية', NULL, 'zalat39@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(497, 3, 'رامي مصطفي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Nursing Manager', NULL, 'ramyr665@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(498, 3, 'Waled Elfwahry', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Colonel', NULL, 'x_man3031@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(499, 3, 'El Mezoghi Adel', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Designer', NULL, 'a.aaadel@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(500, 3, 'abeer mahmoud mohamed ali', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'LA .Architect', NULL, 'abeermohmoud@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(501, 3, 'وليد العمده', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس', NULL, 'waleedelsofany@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(502, 3, 'Hamza Mohemad Mohy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'تاجر', NULL, 'mdmpop_pepo@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(503, 3, 'ياسر عزت', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Financial Analyst', NULL, 'yaserazzat@yahoi.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(504, 3, 'محمد أحمد  حمودة', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'م.ملاحظ', NULL, 'mhamouda720@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(505, 3, 'على السيد علي محمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدرس', NULL, 'abobadr47@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(506, 3, 'Yaser Alsmahy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'f', NULL, 'yasora55@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(507, 3, 'احمدالسيدمحمدعقيلة', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'لا يوجد', NULL, 'akila0500@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(508, 3, 'Mohamed hamd', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'إدارة المراجعة', NULL, 'mohamed_hamed2200@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(509, 3, 'Mahmoud Ahmad Agwa', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاسب', NULL, 'mahmoudagwa503@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(510, 3, 'Khaled Elhadarey', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير تسويق ومبيعات', NULL, 'kelhadsrey@yshoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(511, 3, 'Ahmed Samir ahmed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Concierge Services', NULL, 'ah.samir2020@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(512, 3, 'Akram Ghrib', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'منتج نشرات اخبارية', NULL, 'akramghrib28@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(513, 3, 'Mahmoud Abo Omr', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Technical Fiber Optics', NULL, 'modelove604@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(514, 3, 'Ahmed Hmdy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Lecturer', NULL, 'ahmed_hmdy_2007@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(515, 3, 'Ahmed Mido', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير عام برنامج &quot; صناعة التاجر &quot; الريادي', NULL, 'medorere89@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(516, 3, 'عادل صلاح الليثي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير عام', NULL, 'adelellithy85@gmil.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(517, 3, 'Mohamed Ali', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مهندس زراعى', NULL, 'alim35074@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(518, 3, 'mohammed alnady', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير جمعيه خيريه', NULL, 'alnady2020@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(519, 3, 'Ahmed Sobhaeyy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Project Manager', NULL, 'ahmedsobheyy@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(520, 3, 'Marwà Ezz Elden', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'المدير العام', NULL, 'marwa_ezz92@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(521, 3, 'Doaa Shawqi', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Manager', NULL, 'doniadody589@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(522, 3, 'Mody Mo', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'diploma', NULL, 'modykg1computer@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(523, 3, 'Osama Elmasry', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'لاتوجد', NULL, 'elmasry0mm@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(524, 3, 'Ahmed Abdel Nasser', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'فنى خراط', NULL, 'alshayeb.com94@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(525, 3, 'شريف حمدى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'رقيب', NULL, 'sherif.hamdy@sescotrans.gmail', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(526, 3, 'Mohamed Aboelkhair', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مشروع  بدون شهادات', NULL, 'mohamedaboelkhair@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(527, 3, 'Nancy Abosamra', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مندوب مبيعات', NULL, 'didi_ragab@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(528, 3, 'رامبو رامبو', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير موارد بشرية وشؤون ادارية', NULL, 'sexs77777@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(529, 3, 'Mohamed ashraf', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالب جامعة', NULL, 'momobo55@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(530, 3, 'احمد سيد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'شركة راز الطبية قسم قسطرة القلب - مجموعة راز القابضة - حاضنات الأعمال , احدى شركات الزامل', NULL, 'ahmed_sayd733@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(531, 3, 'بودى عشاب', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Manager', NULL, 'boody.ash84@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(532, 3, 'مغلق للتحسينات', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مساعدطبيب', NULL, 'yaseensay@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(533, 3, 'Hosny Hasan', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاضر', NULL, 'hosnyalodary@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(534, 3, 'نصر عبدالسﻻم', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير إداري', NULL, 'nasr_elmetwaly@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(535, 3, 'ﻣﻴﻨﺎ لوزي رياض عطايه', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاسب', NULL, 'mina123411@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(536, 3, 'محمدعبد الفتاح محمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Administrator', NULL, 'hmadaalwzer@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(537, 3, 'محمد عيسى عبد السلام عبداللطيف قنديل', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'CNC OPERATOR CUM PROGRAMMER', NULL, 'mohamedkandel034@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(538, 3, 'Mohamed Abd Elkader', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مندوب مببعات', NULL, 'monelove493@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49');
INSERT INTO `customercrm` (`customerCrmId`, `addedby`, `customerCrmName`, `customerCrmPhone`, `customerCrmSecondPhone`, `customerCrmEmail`, `customerCrmCompany`, `customerCrmGov`, `customerCrmJob`, `customerCrmQualification`, `customerCrmCountry`, `customerCrmAddress`, `customerCrmAge`, `customerCrmGender`, `customerCrmActivity`, `customerCrmOther`, `customerCrmCreateDate`) VALUES
(539, 3, 'اسلام القصاص', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Hr', NULL, 'islam_agor@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(540, 3, 'الاعلامى أحمد الحسينى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اخصائي تسويق', NULL, 'ahmed.el7seny@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(541, 3, 'عمرو خالد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اعمال حرة', NULL, 'afrekan00@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(542, 3, 'Hussein Amin', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Account Manager', NULL, 'abo.amin22@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(543, 3, 'ZiZo Abden', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'gm', NULL, 'zizo_abden_10@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(544, 3, 'Abrehm Mhmwed Abrehm', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'لا يوجد', NULL, 'hh0108092353@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(545, 3, 'وليد محمد عبدالرحمن عبدالجليل', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Founder', NULL, 'walidmari1@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(546, 3, 'الشيخ حاتم نبيه', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'رجل اعمال', NULL, 'ado_hasn@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(547, 3, 'Ahmed Fouad', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Lecturer', NULL, 'tito_fouash@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(548, 3, 'حسام حسن', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اعمل في مستشفى الملك فهد المركزي بجيزان.', NULL, 'hk_111_11_1@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:49'),
(549, 3, 'Hanibalsadekelafune Elafune', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مندوب اعلانات', NULL, '5hanebalitours@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(550, 3, 'Dola Fawzy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير فرع', NULL, 'dolafawzy_nolove@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(551, 3, 'Gasser Mohamed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Sales Consultant', NULL, 'gasserw2002@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(552, 3, 'محمد سامي محمد رضوان', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير', NULL, 'bosho99@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(553, 3, 'محمود بودافون', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Sounir. Engneer.  Civil', NULL, 'midofone2014@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(554, 3, 'عصام السعيد محمد السعيد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Project Manager', NULL, 'layaly51@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(555, 3, 'Mohamed Mosstafa', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'pharmacist', NULL, 'memo2010_541@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(556, 3, 'Aya Nasr', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'صاحب مؤسسه', NULL, 'nasraya918@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(557, 3, 'مينا موريس', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير الموارد البشريه', NULL, 'minamorees@live.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(558, 3, 'Hossiny Ebrhim', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف', NULL, 'bassmala_2003@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(559, 3, 'samy abd elwahab elazb', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'المهندس', NULL, 'samyelazb@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(560, 3, 'Aiman Mohamed Darweash', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Managing Editor', NULL, 'al.darweash@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(561, 3, 'Hsham Magdy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مستشار - عضو هيئة تدريس', NULL, 'hsham_tito@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(562, 3, 'Hassan El Ashry', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير تجاري', NULL, 'elhareef_e@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(563, 3, 'Kareem Gomaa', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'وكيل مدرسة', NULL, 'krym.jwm@mail.ru', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(564, 3, 'وائل فتحى فواد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'كاتب', NULL, 'waelfathy768@Yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(565, 3, 'Adel Nagaty', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'استاذ', NULL, 'adlnjaty@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(566, 3, 'حودة شاكر', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'CEO', NULL, 'hoda_eldod47@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(567, 3, 'احمد محمود حميد محمود احمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'لايوجد', NULL, 'wwwAhmedalotaiby890@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(568, 3, 'Ahmed Ayman', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'م', NULL, 'madaa550@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(569, 3, 'Cap Abdallah Atc', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير الابتعاث', NULL, 'baloobaloo244@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(570, 3, 'Ȝłį Ĕšmý ßǿy-ẌǷƿ', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير عام الشركة', NULL, 'mahmoudbayo96@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(571, 3, 'Eslam hassan hassan mohamed morgan', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'بروفيسور', NULL, 'eslamhassan239@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(572, 3, 'احمد عبدالله', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'المدير التنفيذي', NULL, 'ahmevip305@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(573, 3, 'Selfraz Nassar', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف', NULL, 'selfraz.nassar@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(574, 3, 'Essam Aladhm', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Quality Control Supervisor', NULL, 'essamaladhm11@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(575, 3, 'Ahmed Hassan', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'بين المداد والكراس', NULL, 'Zezo_fire_love@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(576, 3, 'محمد حسين حماده حسين', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Operations Manager', NULL, 'mido2010_man2010@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(577, 3, 'انس العقباوى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Ophthalmologist', NULL, 'anas_anas10530@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(578, 3, 'Abdala Mahamd', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Technical Account Manager', NULL, 'Andala.mahamd@yam.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(579, 3, 'Murad Salah', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير التنفيدي', NULL, 'moradsalah1010@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(580, 3, 'م.عمرو عبدالفتاح', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Electrical Engineer', NULL, 'Fawzy22333@yohoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(581, 3, 'حماده رفعت الداودى فوده', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'عمال حره', NULL, 'hamadarefaat00@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(582, 3, 'احمد فتحى سعد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Director general', NULL, 'elkpt@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(583, 3, 'Koka Tota', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Supervisor', NULL, 'hagerkoka72@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(584, 3, 'ﻣﺤﻤﺪ ﻣﺤﻤﻮﺩ نورالدين', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'بكالوريوس علم الاجتماع السياسي', NULL, 'am516873@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(585, 3, 'خلف جمال محمد شحات', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Veterinarian', NULL, 'khalafgamal559@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(586, 3, 'Sameh Kenawy.سامح محمد قناوى سالم', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موارد بشرية', NULL, 'samehkenawy365@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(587, 3, 'Mahmoud Shaaban', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاسب', NULL, 'mahmoud.shaaban.africana@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(588, 3, 'Mazen Elmogy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Account Manager', NULL, 'wageh12551@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(589, 3, 'Esam Elrayes', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مفاولات', NULL, 'esam_elrayes@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(590, 3, 'Äňă Ăļ Wăđ Føx', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Accountant', NULL, 'ahmedfox2324@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(591, 3, 'Hocy Esmail', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'أستشاري موارد بشرية ومدير التدريب الأداري', NULL, 'hossnni6@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(592, 3, 'Asim El-Daly', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مشاريع في مؤسسة قطاع خاص', NULL, 'assem_adel@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(593, 3, 'احمد منير مصطفى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Human Resources Manager', NULL, 'mohamedmonirhack@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(594, 3, 'Mostafa Tamem', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'وكيل شؤون تعليمية لمدرسة ثانوية', NULL, 'tam_em_88@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(595, 3, 'Amr Gamal', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاسب', NULL, 'amrelsheikh2014@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(596, 3, 'Sea Row', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Translator/Interpreter', NULL, 'sarahsaleh365@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(597, 3, 'عفيفي احمد عفيفي مصطفى', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محاسب', NULL, 'aboafify_2012@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(598, 3, 'يوسف وهايدى عبد العال', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'engineer', NULL, 'Yousoof12345446@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(599, 3, 'محمد ابراهيم', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'general manager', NULL, 'mo6010@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(600, 3, 'Karim Keshoo', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'pharmacist', NULL, 'kkarim734@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(601, 3, 'Mohamed ALi', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'ممرضه', NULL, 'aboyossef125@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(602, 3, 'Mohamed Yousef', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مالي', NULL, 'wmw017@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(603, 3, 'Ahmed Elsherif', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محصل', NULL, 'ahmedelsherif39@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(604, 3, 'Fathe Esa', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'اخصاءية تدريب', NULL, 'fathe_esa@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(605, 3, 'شيرين محمد محمد راشد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طلب جمعي', NULL, 'ali.foural@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(606, 3, 'مجدى عبد الرحيم', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Manager', NULL, 'magdyabdelrhim@outlook.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(607, 3, 'Elbasha Khater', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'رجل اعمال', NULL, 'elbasha_elbasha1239@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(608, 3, 'Awad Eid', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مصلح حاسبات وموبيلات', NULL, 'aboeid45@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(609, 3, 'Mohamed Fakhry', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'حقل البيضاء', NULL, 'm.fakhry1173@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(610, 3, 'Fares Magdy Almaz', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'محقق', NULL, 'fares.almaz@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(611, 3, 'هاني وديع', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف', NULL, 'dode.hani@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(612, 3, 'Eman Diab', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Assistant Claims Manager', NULL, 'emyd72a@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(613, 3, 'Heba Ali', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مو ظيفي', NULL, 'a.heba47@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(614, 3, 'Mahmoud Sobhy', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Customer Service Associate (CSA)', NULL, 'fox_movx@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(615, 3, 'Ahmed Mohamed Ahmed Selim', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مبيعات', NULL, 'Ahmedslim2009@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(616, 3, 'سلطان زمانه', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدرس', NULL, 'ahmed_mido8117@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(617, 3, 'شمس اﻻمل', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'CEO', NULL, 'nona2015160@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(618, 3, 'ميشيل مدحت', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مركز خدمة الزبائن', NULL, 'mishomedhat@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(619, 3, 'Ibrahim Hima', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'Civil eng', NULL, 'himaboge25@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(620, 3, 'Nasser Abdullah Abderrady', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مساعد مهندس', NULL, 'nasserabohazem1971@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(621, 3, 'احمد شوقى محمد حامد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدرس', NULL, 'ahmedshowky544@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(622, 3, 'Alaa Hussein', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير عام', NULL, 'alaa1kiki@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(623, 3, 'الله المستعان على ماتصفون', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'رئيس قسم التوثيق وتقنية المعلومات بجهاز الاسعاف', NULL, 'hh1966066@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(624, 3, 'السيد محمد علي محمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'أعمال حره', NULL, 'wo45037@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(625, 3, 'ابراهيم مصطفي الدغيدي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'فندق', NULL, 'ebrahimmostafa422@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(626, 3, 'Mohamed Hussein Moustafa', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'سكرتير', NULL, 'mohamed.hussein2011@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(627, 3, 'Mohumed Shams Hussin', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'خريج وابحث عن وظيفة', NULL, 'shaws_shaws2000@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(628, 3, 'Mohammed Fouad', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'طالب جامعي', NULL, 'fokshbasha_2006@hotmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(629, 3, 'Mohamed Saleh', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'موظف حكومي', NULL, 'original201394@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(630, 3, 'Mohamed Yahia', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مندوب مبيعات', NULL, 'mygaa2002@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(631, 3, 'Casper Wade', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير مشروع', NULL, 'm_mod44@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(632, 3, 'Sameh Kamal', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'it programmer', NULL, 'kamalsameh771@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(633, 3, 'Âhmêd Wêêkâ', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'كاسب', NULL, 'ahmedlovely2014@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(634, 3, 'Mohamed Sayed', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مدير عام شركه', NULL, 'mody.50650@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(635, 3, 'محمد حماصه', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'عضو هيئة تدريس', NULL, 'thhamasa@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(636, 3, 'Esraa Elnakib', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'وزير مفوص الخارجية الليبية', NULL, 'israaelnakib@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(637, 3, 'احمد حسن عبد العزيز محمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مقاولات عامة', NULL, 'Ahmed.hassan274@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(638, 3, 'Mohamed Hamza', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'مقاتل', NULL, 'hamzaweyyyyy@gmail.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(639, 3, 'Hossam Abd Alzaher', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'إدارة مكتب', NULL, 'safe_elfares@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(640, 3, 'ام حفص وجويرية احمد', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'صحفي', NULL, 'ahmedkamel3456@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50'),
(641, 3, 'بلال مجدي', '01114355330', NULL, 'abdob2623@gmail.com', NULL, NULL, 'تاجر', NULL, 'fhghhh@yahoo.com', NULL, NULL, b'0', NULL, NULL, '2019-09-14 14:40:50');

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
(1, 33, 32, 1, '2019-09-14', '02:50:00', 15, 32, b'0'),
(2, 33, 32, 2, '2019-09-16', '03:33:00', 15, 32, b'0'),
(3, 33, 32, 3, '2019-09-14', '02:42:48', 1, 32, b'0'),
(4, 33, 32, 4, '2019-09-14', '02:42:48', 1, 32, b'0'),
(5, 33, 32, 5, '2019-09-14', '02:42:48', 1, 32, b'0'),
(6, 33, 32, 6, '2019-09-14', '02:42:48', 1, 32, b'0'),
(7, 33, 32, 7, '2019-09-14', '02:42:48', 1, 32, b'0'),
(8, 33, 32, 8, '2019-09-14', '02:42:48', 1, 32, b'0'),
(9, 33, 32, 9, '2019-09-14', '02:42:48', 1, 32, b'0'),
(10, 33, 32, 10, '2019-09-14', '02:42:48', 1, 32, b'0'),
(11, 32, NULL, 11, '2019-09-16', '05:20:13', 15, 3, b'1'),
(12, 33, 32, 12, '2019-09-14', '03:40:00', 27, 32, b'0'),
(13, 34, NULL, 13, '2019-09-17', '03:16:14', 1, 3, b'0'),
(14, 33, 32, 14, '2019-09-14', '02:42:48', 1, 32, b'0'),
(15, 33, 32, 15, '2019-09-14', '02:42:48', 1, 32, b'0'),
(16, 33, 32, 16, '2019-09-14', '02:42:48', 1, 32, b'0'),
(17, 33, 32, 17, '2019-09-14', '02:42:48', 1, 32, b'0'),
(18, 33, 32, 18, '2019-09-14', '02:42:48', 1, 32, b'0'),
(19, 33, 32, 19, '2019-09-14', '02:42:48', 1, 32, b'0'),
(20, 33, 32, 20, '2019-09-14', '02:42:48', 1, 32, b'0'),
(21, 33, 32, 21, '2019-09-14', '02:42:48', 1, 32, b'0'),
(22, 33, 32, 22, '2019-09-14', '02:42:48', 1, 32, b'0'),
(23, 33, 32, 23, '2019-09-14', '02:42:48', 1, 32, b'0'),
(24, 33, 32, 24, '2019-09-14', '02:42:48', 1, 32, b'0'),
(25, 33, 32, 25, '2019-09-14', '02:42:48', 1, 32, b'0'),
(26, 33, 32, 26, '2019-09-14', '02:42:48', 1, 32, b'0'),
(27, 33, 32, 27, '2019-09-14', '02:42:48', 1, 32, b'0'),
(28, 33, 32, 28, '2019-09-14', '02:42:48', 1, 32, b'0'),
(29, 33, 32, 29, '2019-09-14', '02:42:48', 1, 32, b'0'),
(30, 33, 32, 30, '2019-09-14', '02:42:48', 1, 32, b'0'),
(31, 33, 32, 31, '2019-09-14', '02:42:48', 1, 32, b'0'),
(32, 33, 32, 32, '2019-09-14', '02:42:48', 1, 32, b'0'),
(33, 33, 32, 33, '2019-09-14', '02:42:48', 1, 32, b'0'),
(34, 33, 32, 34, '2019-09-14', '02:42:48', 1, 32, b'0'),
(35, 33, 32, 35, '2019-09-14', '02:42:48', 1, 32, b'0'),
(36, 33, 32, 36, '2019-09-14', '02:42:48', 1, 32, b'0'),
(37, 33, 32, 37, '2019-09-14', '02:42:48', 1, 32, b'0'),
(38, 33, 32, 38, '2019-09-14', '02:42:48', 1, 32, b'0'),
(39, 33, 32, 39, '2019-09-14', '02:42:48', 1, 32, b'0'),
(40, 33, 32, 40, '2019-09-14', '02:42:48', 1, 32, b'0'),
(41, 33, 32, 41, '2019-09-14', '02:42:49', 1, 32, b'0'),
(42, 33, 32, 42, '2019-09-14', '02:42:49', 1, 32, b'0'),
(43, 33, 32, 43, '2019-09-14', '02:42:49', 1, 32, b'0'),
(44, 33, 32, 44, '2019-09-14', '02:42:49', 1, 32, b'0'),
(45, 33, 32, 45, '2019-09-14', '02:42:49', 1, 32, b'0'),
(46, 33, 32, 46, '2019-09-14', '02:42:49', 1, 32, b'0'),
(47, 33, 32, 47, '2019-09-14', '02:42:49', 1, 32, b'0'),
(48, 33, 32, 48, '2019-09-14', '02:42:49', 1, 32, b'0'),
(49, 33, 32, 49, '2019-09-14', '02:42:49', 1, 32, b'0'),
(50, 33, 32, 50, '2019-09-14', '02:42:49', 1, 32, b'0'),
(51, 33, 32, 51, '2019-09-14', '02:42:49', 1, 32, b'0'),
(52, 33, 32, 52, '2019-09-14', '02:42:49', 1, 32, b'0'),
(53, 33, 32, 53, '2019-09-14', '02:42:49', 1, 32, b'0'),
(54, 33, 32, 54, '2019-09-14', '02:42:49', 1, 32, b'0'),
(55, 33, 32, 55, '2019-09-14', '02:42:49', 1, 32, b'0'),
(56, 33, 32, 56, '2019-09-14', '02:42:49', 1, 32, b'0'),
(57, 33, 32, 57, '2019-09-14', '02:42:49', 1, 32, b'0'),
(58, 33, 32, 58, '2019-09-14', '02:42:49', 1, 32, b'0'),
(59, 33, 32, 59, '2019-09-14', '02:42:49', 1, 32, b'0'),
(60, 33, 32, 60, '2019-09-14', '02:42:49', 1, 32, b'0'),
(61, 33, 32, 61, '2019-09-14', '02:42:49', 1, 32, b'0'),
(62, 33, 32, 62, '2019-09-14', '02:42:49', 1, 32, b'0'),
(63, 33, 32, 63, '2019-09-14', '02:42:49', 1, 32, b'0'),
(64, 33, 32, 64, '2019-09-14', '02:42:49', 1, 32, b'0'),
(65, 33, 32, 65, '2019-09-14', '02:42:49', 1, 32, b'0'),
(66, 33, 32, 66, '2019-09-14', '02:42:49', 1, 32, b'0'),
(67, 33, 32, 67, '2019-09-14', '02:42:49', 1, 32, b'0'),
(68, 33, 32, 68, '2019-09-14', '02:42:49', 1, 32, b'0'),
(69, 33, 32, 69, '2019-09-14', '02:42:49', 1, 32, b'0'),
(70, 33, 32, 70, '2019-09-14', '02:42:49', 1, 32, b'0'),
(71, 33, 32, 71, '2019-09-14', '02:42:49', 1, 32, b'0'),
(72, 33, 32, 72, '2019-09-14', '02:42:49', 1, 32, b'0'),
(73, 33, 32, 73, '2019-09-14', '02:42:49', 1, 32, b'0'),
(74, 33, 32, 74, '2019-09-14', '02:42:49', 1, 32, b'0'),
(75, 33, 32, 75, '2019-09-14', '02:42:49', 1, 32, b'0'),
(76, 33, 32, 76, '2019-09-14', '02:42:49', 1, 32, b'0'),
(77, 33, 32, 77, '2019-09-14', '02:42:49', 1, 32, b'0'),
(78, 33, 32, 78, '2019-09-14', '02:42:49', 1, 32, b'0'),
(79, 33, 32, 79, '2019-09-14', '02:42:49', 1, 32, b'0'),
(80, 33, 32, 80, '2019-09-14', '02:42:49', 1, 32, b'0'),
(81, 33, 32, 81, '2019-09-14', '02:42:49', 1, 32, b'0'),
(82, 33, 32, 82, '2019-09-14', '02:42:49', 1, 32, b'0'),
(83, 33, 32, 83, '2019-09-14', '02:42:49', 1, 32, b'0'),
(84, 33, 32, 84, '2019-09-14', '02:42:49', 1, 32, b'0'),
(85, 33, 32, 85, '2019-09-14', '02:42:49', 1, 32, b'0'),
(86, 33, 32, 86, '2019-09-14', '02:42:49', 1, 32, b'0'),
(87, 33, 32, 87, '2019-09-14', '02:42:49', 1, 32, b'0'),
(88, 33, 32, 88, '2019-09-14', '02:42:49', 1, 32, b'0'),
(89, 33, 32, 89, '2019-09-14', '02:42:49', 1, 32, b'0'),
(90, 33, 32, 90, '2019-09-14', '02:42:49', 1, 32, b'0'),
(91, 33, 32, 91, '2019-09-14', '02:42:49', 1, 32, b'0'),
(92, 33, 32, 92, '2019-09-14', '02:42:49', 1, 32, b'0'),
(93, 33, 32, 93, '2019-09-14', '02:42:49', 1, 32, b'0'),
(94, 33, 32, 94, '2019-09-14', '02:42:49', 1, 32, b'0'),
(95, 33, 32, 95, '2019-09-14', '02:42:49', 1, 32, b'0'),
(96, 33, 32, 96, '2019-09-14', '02:42:49', 1, 32, b'0'),
(97, 33, 32, 97, '2019-09-14', '02:42:49', 1, 32, b'0'),
(98, 33, 32, 98, '2019-09-14', '02:42:49', 1, 32, b'0'),
(99, 33, 32, 99, '2019-09-14', '02:42:49', 1, 32, b'0'),
(100, 33, 32, 100, '2019-09-14', '02:42:49', 1, 32, b'0'),
(101, 32, NULL, 101, '2019-09-18', '05:00:11', 15, 3, b'1'),
(102, 33, 32, 102, '2019-09-14', '02:51:00', 15, 32, b'0'),
(103, 32, NULL, 103, '2019-09-18', '05:00:11', 15, 3, b'1'),
(104, 33, 32, 104, '2019-09-14', '03:37:00', 21, 32, b'0'),
(105, 33, 32, 105, '2019-09-14', '03:37:00', 29, 32, b'0'),
(106, 33, 32, 106, '2019-09-14', '03:38:00', 36, 32, b'0'),
(107, 32, NULL, 107, '2019-09-16', '05:20:13', 15, 3, b'1'),
(108, 33, 32, 108, '2019-09-14', '03:39:00', 39, 32, b'0'),
(109, 33, 32, 109, '2019-09-16', '05:20:27', 25, 3, b'1'),
(110, 33, 32, 110, '2019-09-14', '03:39:00', 26, 32, b'0'),
(111, 33, 32, 111, '2019-09-14', '03:40:00', 31, 32, b'0'),
(112, 33, 32, 112, '2019-09-14', '03:41:00', 32, 32, b'0'),
(113, 33, 32, 113, '2019-09-14', '03:41:00', 33, 32, b'0'),
(114, 33, 32, 114, '2019-09-14', '03:41:00', 35, 32, b'0'),
(115, 34, NULL, 115, '2019-09-17', '03:16:14', 1, 3, b'0'),
(116, 34, NULL, 116, '2019-09-17', '03:16:14', 1, 3, b'0'),
(117, 34, NULL, 117, '2019-09-17', '03:16:14', 1, 3, b'0'),
(118, 34, NULL, 118, '2019-09-17', '03:16:14', 1, 3, b'0'),
(119, 34, NULL, 119, '2019-09-17', '03:16:14', 1, 3, b'0'),
(120, 34, NULL, 120, '2019-09-17', '03:16:14', 1, 3, b'0'),
(121, 34, NULL, 121, '2019-09-17', '03:16:14', 1, 3, b'0'),
(122, 34, NULL, 122, '2019-09-17', '03:16:14', 1, 3, b'0'),
(123, 34, NULL, 123, '2019-09-17', '03:16:14', 1, 3, b'0'),
(124, 33, 32, 124, '2019-09-14', '02:42:49', 1, 32, b'0'),
(125, 33, 32, 125, '2019-09-14', '02:42:49', 1, 32, b'0'),
(126, 33, 32, 126, '2019-09-14', '02:42:49', 1, 32, b'0'),
(127, 33, 32, 127, '2019-09-14', '02:42:49', 1, 32, b'0'),
(128, 33, 32, 128, '2019-09-14', '02:42:49', 1, 32, b'0'),
(129, 33, 32, 129, '2019-09-14', '02:42:49', 1, 32, b'0'),
(130, 33, 32, 130, '2019-09-14', '02:42:49', 1, 32, b'0'),
(131, 33, 32, 131, '2019-09-14', '02:42:49', 1, 32, b'0'),
(132, 33, 32, 132, '2019-09-14', '02:42:49', 1, 32, b'0'),
(133, 33, 32, 133, '2019-09-14', '02:42:49', 1, 32, b'0'),
(134, 33, 32, 134, '2019-09-14', '02:42:49', 1, 32, b'0'),
(135, 33, 32, 135, '2019-09-14', '02:42:49', 1, 32, b'0'),
(136, 33, 32, 136, '2019-09-14', '02:42:49', 1, 32, b'0'),
(137, 33, 32, 137, '2019-09-14', '02:42:49', 1, 32, b'0'),
(138, 33, 32, 138, '2019-09-14', '02:42:49', 1, 32, b'0'),
(139, 33, 32, 139, '2019-09-14', '02:42:49', 1, 32, b'0'),
(140, 33, 32, 140, '2019-09-14', '02:42:49', 1, 32, b'0'),
(141, 33, 32, 141, '2019-09-14', '02:42:49', 1, 32, b'0'),
(142, 33, 32, 142, '2019-09-14', '02:42:49', 1, 32, b'0'),
(143, 33, 32, 143, '2019-09-14', '02:42:49', 1, 32, b'0'),
(144, 33, 32, 144, '2019-09-14', '02:42:49', 1, 32, b'0'),
(145, 33, 32, 145, '2019-09-14', '02:42:49', 1, 32, b'0'),
(146, 33, 32, 146, '2019-09-14', '02:42:49', 1, 32, b'0'),
(147, 33, 32, 147, '2019-09-14', '02:42:49', 1, 32, b'0'),
(148, 33, 32, 148, '2019-09-14', '02:42:49', 1, 32, b'0'),
(149, 33, 32, 149, '2019-09-14', '02:42:49', 1, 32, b'0'),
(150, 33, 32, 150, '2019-09-14', '02:42:49', 1, 32, b'0'),
(151, 32, NULL, 151, '2019-09-14', '02:41:17', 1, 3, b'0'),
(152, 32, NULL, 152, '2019-09-14', '02:41:17', 1, 3, b'0'),
(153, 32, NULL, 153, '2019-09-14', '02:41:17', 1, 3, b'0'),
(154, 32, NULL, 154, '2019-09-14', '02:41:17', 1, 3, b'0'),
(155, 32, NULL, 155, '2019-09-14', '02:41:17', 1, 3, b'0'),
(156, 32, NULL, 156, '2019-09-14', '02:41:17', 1, 3, b'0'),
(157, 32, NULL, 157, '2019-09-14', '02:41:17', 1, 3, b'0'),
(158, 32, NULL, 158, '2019-09-14', '02:41:17', 1, 3, b'0'),
(159, 32, NULL, 159, '2019-09-14', '02:41:17', 1, 3, b'0'),
(160, 32, NULL, 160, '2019-09-14', '02:41:17', 1, 3, b'0'),
(161, 32, NULL, 161, '2019-09-14', '02:41:17', 1, 3, b'0'),
(162, 32, NULL, 162, '2019-09-14', '02:41:17', 1, 3, b'0'),
(163, 32, NULL, 163, '2019-09-14', '02:41:17', 1, 3, b'0'),
(164, 32, NULL, 164, '2019-09-14', '02:41:17', 1, 3, b'0'),
(165, 32, NULL, 165, '2019-09-14', '02:41:17', 1, 3, b'0'),
(166, 32, NULL, 166, '2019-09-14', '02:41:17', 1, 3, b'0'),
(167, 32, NULL, 167, '2019-09-14', '02:41:17', 1, 3, b'0'),
(168, 32, NULL, 168, '2019-09-14', '02:41:17', 1, 3, b'0'),
(169, 32, NULL, 169, '2019-09-14', '02:41:17', 1, 3, b'0'),
(170, 32, NULL, 170, '2019-09-14', '02:41:17', 1, 3, b'0'),
(171, 32, NULL, 171, '2019-09-14', '02:41:17', 1, 3, b'0'),
(172, 32, NULL, 172, '2019-09-14', '02:41:17', 1, 3, b'0'),
(173, 32, NULL, 173, '2019-09-14', '02:41:17', 1, 3, b'0'),
(174, 32, NULL, 174, '2019-09-14', '02:41:17', 1, 3, b'0'),
(175, 32, NULL, 175, '2019-09-14', '02:41:17', 1, 3, b'0'),
(176, 32, NULL, 176, '2019-09-14', '02:41:17', 1, 3, b'0'),
(177, 32, NULL, 177, '2019-09-14', '02:41:17', 1, 3, b'0'),
(178, 32, NULL, 178, '2019-09-14', '02:41:17', 1, 3, b'0'),
(179, 32, NULL, 179, '2019-09-14', '02:41:17', 1, 3, b'0'),
(180, 32, NULL, 180, '2019-09-14', '02:41:17', 1, 3, b'0'),
(181, 32, NULL, 181, '2019-09-14', '02:41:17', 1, 3, b'0'),
(182, 32, NULL, 182, '2019-09-14', '02:41:17', 1, 3, b'0'),
(183, 32, NULL, 183, '2019-09-14', '02:41:17', 1, 3, b'0'),
(184, 32, NULL, 184, '2019-09-14', '02:41:17', 1, 3, b'0'),
(185, 32, NULL, 185, '2019-09-14', '02:41:17', 1, 3, b'0'),
(186, 32, NULL, 186, '2019-09-14', '02:41:17', 1, 3, b'0'),
(187, 32, NULL, 187, '2019-09-14', '02:41:17', 1, 3, b'0'),
(188, 32, NULL, 188, '2019-09-14', '02:41:17', 1, 3, b'0'),
(189, 32, NULL, 189, '2019-09-14', '02:41:17', 1, 3, b'0'),
(190, 32, NULL, 190, '2019-09-14', '02:41:17', 1, 3, b'0'),
(191, 32, NULL, 191, '2019-09-14', '02:41:17', 1, 3, b'0'),
(192, 32, NULL, 192, '2019-09-14', '02:41:17', 1, 3, b'0'),
(193, 32, NULL, 193, '2019-09-14', '02:41:17', 1, 3, b'0'),
(194, 32, NULL, 194, '2019-09-14', '02:41:17', 1, 3, b'0'),
(195, 32, NULL, 195, '2019-09-14', '02:41:17', 1, 3, b'0'),
(196, 32, NULL, 196, '2019-09-14', '02:41:17', 1, 3, b'0'),
(197, 32, NULL, 197, '2019-09-14', '02:41:17', 1, 3, b'0'),
(198, 32, NULL, 198, '2019-09-14', '02:41:17', 1, 3, b'0'),
(199, 32, NULL, 199, '2019-09-14', '02:41:17', 1, 3, b'0'),
(200, 32, NULL, 200, '2019-09-14', '02:41:17', 1, 3, b'0'),
(201, 32, NULL, 201, '2019-09-14', '02:41:17', 1, 3, b'0'),
(202, 32, NULL, 202, '2019-09-14', '02:41:17', 1, 3, b'0'),
(203, 32, NULL, 203, '2019-09-14', '02:41:17', 1, 3, b'0'),
(204, 32, NULL, 204, '2019-09-14', '02:41:17', 1, 3, b'0'),
(205, 32, NULL, 205, '2019-09-14', '02:41:17', 1, 3, b'0'),
(206, 32, NULL, 206, '2019-09-14', '02:41:17', 1, 3, b'0'),
(207, 32, NULL, 207, '2019-09-14', '02:41:17', 1, 3, b'0'),
(208, 32, NULL, 208, '2019-09-14', '02:41:17', 1, 3, b'0'),
(209, 32, NULL, 209, '2019-09-14', '02:41:17', 1, 3, b'0'),
(210, 32, NULL, 210, '2019-09-14', '02:41:17', 1, 3, b'0'),
(211, 32, NULL, 211, '2019-09-14', '02:41:17', 1, 3, b'0'),
(212, 32, NULL, 212, '2019-09-14', '02:41:17', 1, 3, b'0'),
(213, 32, NULL, 213, '2019-09-14', '02:41:17', 1, 3, b'0'),
(214, 32, NULL, 214, '2019-09-14', '02:41:17', 1, 3, b'0'),
(215, 32, NULL, 215, '2019-09-14', '02:41:17', 1, 3, b'0'),
(216, 32, NULL, 216, '2019-09-14', '02:41:17', 1, 3, b'0'),
(217, 32, NULL, 217, '2019-09-14', '02:41:17', 1, 3, b'0'),
(218, 32, NULL, 218, '2019-09-14', '02:41:17', 1, 3, b'0'),
(219, 32, NULL, 219, '2019-09-14', '02:41:17', 1, 3, b'0'),
(220, 32, NULL, 220, '2019-09-14', '02:41:17', 1, 3, b'0'),
(221, 32, NULL, 221, '2019-09-14', '02:41:17', 1, 3, b'0'),
(222, 32, NULL, 222, '2019-09-14', '02:41:17', 1, 3, b'0'),
(223, 32, NULL, 223, '2019-09-14', '02:41:17', 1, 3, b'0'),
(224, 32, NULL, 224, '2019-09-14', '02:41:17', 1, 3, b'0'),
(225, 32, NULL, 225, '2019-09-14', '02:41:17', 1, 3, b'0'),
(226, 32, NULL, 226, '2019-09-14', '02:41:17', 1, 3, b'0'),
(227, 32, NULL, 227, '2019-09-14', '02:41:17', 1, 3, b'0'),
(228, 32, NULL, 228, '2019-09-14', '02:41:17', 1, 3, b'0'),
(229, 32, NULL, 229, '2019-09-14', '02:41:17', 1, 3, b'0'),
(230, 32, NULL, 230, '2019-09-14', '02:41:17', 1, 3, b'0'),
(231, 32, NULL, 231, '2019-09-14', '02:41:17', 1, 3, b'0'),
(232, 32, NULL, 232, '2019-09-14', '02:41:17', 1, 3, b'0'),
(233, 32, NULL, 233, '2019-09-14', '02:41:17', 1, 3, b'0'),
(234, 32, NULL, 234, '2019-09-14', '02:41:17', 1, 3, b'0'),
(235, 32, NULL, 235, '2019-09-14', '02:41:17', 1, 3, b'0'),
(236, 32, NULL, 236, '2019-09-14', '02:41:17', 1, 3, b'0'),
(237, 32, NULL, 237, '2019-09-14', '02:41:17', 1, 3, b'0'),
(238, 32, NULL, 238, '2019-09-14', '02:41:17', 1, 3, b'0'),
(239, 32, NULL, 239, '2019-09-14', '02:41:17', 1, 3, b'0'),
(240, 32, NULL, 240, '2019-09-14', '02:41:17', 1, 3, b'0'),
(241, 32, NULL, 241, '2019-09-14', '02:41:17', 1, 3, b'0'),
(242, 32, NULL, 242, '2019-09-14', '02:41:17', 1, 3, b'0'),
(243, 32, NULL, 243, '2019-09-14', '02:41:17', 1, 3, b'0'),
(244, 32, NULL, 244, '2019-09-14', '02:41:17', 1, 3, b'0'),
(245, 32, NULL, 245, '2019-09-14', '02:41:17', 1, 3, b'0'),
(246, 32, NULL, 246, '2019-09-14', '02:41:17', 1, 3, b'0'),
(247, 32, NULL, 247, '2019-09-14', '02:41:17', 1, 3, b'0'),
(248, 32, NULL, 248, '2019-09-14', '02:41:17', 1, 3, b'0'),
(249, 32, NULL, 249, '2019-09-14', '02:41:17', 1, 3, b'0'),
(250, 32, NULL, 250, '2019-09-14', '02:41:17', 1, 3, b'0'),
(251, 32, NULL, 251, '2019-09-14', '02:41:17', 1, 3, b'0'),
(252, 32, NULL, 252, '2019-09-14', '02:41:17', 1, 3, b'0'),
(253, 32, NULL, 253, '2019-09-14', '02:41:17', 1, 3, b'0'),
(254, 32, NULL, 254, '2019-09-14', '02:41:17', 1, 3, b'0'),
(255, 32, NULL, 255, '2019-09-14', '02:41:17', 1, 3, b'0'),
(256, 32, NULL, 256, '2019-09-14', '02:41:17', 1, 3, b'0'),
(257, 32, NULL, 257, '2019-09-14', '02:41:17', 1, 3, b'0'),
(258, 32, NULL, 258, '2019-09-14', '02:41:17', 1, 3, b'0'),
(259, 32, NULL, 259, '2019-09-14', '02:41:17', 1, 3, b'0'),
(260, 32, NULL, 260, '2019-09-14', '02:41:17', 1, 3, b'0'),
(261, 32, NULL, 261, '2019-09-14', '02:41:17', 1, 3, b'0'),
(262, 32, NULL, 262, '2019-09-14', '02:41:17', 1, 3, b'0'),
(263, 32, NULL, 263, '2019-09-14', '02:41:17', 1, 3, b'0'),
(264, 32, NULL, 264, '2019-09-14', '02:41:17', 1, 3, b'0'),
(265, 32, NULL, 265, '2019-09-14', '02:41:17', 1, 3, b'0'),
(266, 32, NULL, 266, '2019-09-14', '02:41:17', 1, 3, b'0'),
(267, 32, NULL, 267, '2019-09-14', '02:41:17', 1, 3, b'0'),
(268, 32, NULL, 268, '2019-09-14', '02:41:17', 1, 3, b'0'),
(269, 32, NULL, 269, '2019-09-14', '02:41:17', 1, 3, b'0'),
(270, 32, NULL, 270, '2019-09-14', '02:41:17', 1, 3, b'0'),
(271, 32, NULL, 271, '2019-09-14', '02:41:17', 1, 3, b'0'),
(272, 32, NULL, 272, '2019-09-14', '02:41:17', 1, 3, b'0'),
(273, 32, NULL, 273, '2019-09-14', '02:41:17', 1, 3, b'0'),
(274, 32, NULL, 274, '2019-09-14', '02:41:17', 1, 3, b'0'),
(275, 32, NULL, 275, '2019-09-14', '02:41:17', 1, 3, b'0'),
(276, 32, NULL, 276, '2019-09-14', '02:41:17', 1, 3, b'0'),
(277, 32, NULL, 277, '2019-09-14', '02:41:17', 1, 3, b'0'),
(278, 32, NULL, 278, '2019-09-14', '02:41:17', 1, 3, b'0'),
(279, 32, NULL, 279, '2019-09-14', '02:41:17', 1, 3, b'0'),
(280, 32, NULL, 280, '2019-09-14', '02:41:17', 1, 3, b'0'),
(281, 32, NULL, 281, '2019-09-14', '02:41:17', 1, 3, b'0'),
(282, 32, NULL, 282, '2019-09-14', '02:41:17', 1, 3, b'0'),
(283, 32, NULL, 283, '2019-09-14', '02:41:17', 1, 3, b'0'),
(284, 32, NULL, 284, '2019-09-14', '02:41:17', 1, 3, b'0'),
(285, 32, NULL, 285, '2019-09-14', '02:41:17', 1, 3, b'0'),
(286, 32, NULL, 286, '2019-09-14', '02:41:17', 1, 3, b'0'),
(287, 32, NULL, 287, '2019-09-14', '02:41:17', 1, 3, b'0'),
(288, 32, NULL, 288, '2019-09-14', '02:41:17', 1, 3, b'0'),
(289, 32, NULL, 289, '2019-09-14', '02:41:17', 1, 3, b'0'),
(290, 32, NULL, 290, '2019-09-14', '02:41:17', 1, 3, b'0'),
(291, 32, NULL, 291, '2019-09-14', '02:41:17', 1, 3, b'0'),
(292, 32, NULL, 292, '2019-09-14', '02:41:17', 1, 3, b'0'),
(293, 32, NULL, 293, '2019-09-14', '02:41:17', 1, 3, b'0'),
(294, 32, NULL, 294, '2019-09-14', '02:41:17', 1, 3, b'0'),
(295, 32, NULL, 295, '2019-09-14', '02:41:17', 1, 3, b'0'),
(296, 32, NULL, 296, '2019-09-14', '02:41:17', 1, 3, b'0'),
(297, 32, NULL, 297, '2019-09-14', '02:41:17', 1, 3, b'0'),
(298, 32, NULL, 298, '2019-09-14', '02:41:17', 1, 3, b'0'),
(299, 32, NULL, 299, '2019-09-14', '02:41:17', 1, 3, b'0'),
(300, 32, NULL, 300, '2019-09-14', '02:41:17', 1, 3, b'0'),
(301, 33, 32, 301, '2019-09-14', '02:43:46', 1, 3, b'0'),
(302, 33, 32, 302, '2019-09-14', '02:43:46', 1, 3, b'0'),
(303, 33, 32, 303, '2019-09-14', '02:43:46', 1, 3, b'0'),
(304, 33, 32, 304, '2019-09-14', '02:43:46', 1, 3, b'0'),
(305, 33, 32, 305, '2019-09-14', '02:43:46', 1, 3, b'0'),
(306, 33, 32, 306, '2019-09-14', '02:43:46', 1, 3, b'0'),
(307, 33, 32, 307, '2019-09-14', '02:43:46', 1, 3, b'0'),
(308, 33, 32, 308, '2019-09-14', '02:43:46', 1, 3, b'0'),
(309, 33, 32, 309, '2019-09-14', '02:43:46', 1, 3, b'0'),
(310, 33, 32, 310, '2019-09-14', '02:43:46', 1, 3, b'0'),
(311, 33, 32, 311, '2019-09-14', '02:43:46', 1, 3, b'0'),
(312, 33, 32, 312, '2019-09-14', '02:43:46', 1, 3, b'0'),
(313, 33, 32, 313, '2019-09-14', '02:43:46', 1, 3, b'0'),
(314, 33, 32, 314, '2019-09-14', '02:43:46', 1, 3, b'0'),
(315, 33, 32, 315, '2019-09-14', '02:43:46', 1, 3, b'0'),
(316, 33, 32, 316, '2019-09-14', '02:43:46', 1, 3, b'0'),
(317, 33, 32, 317, '2019-09-14', '02:43:46', 1, 3, b'0'),
(318, 33, 32, 318, '2019-09-14', '02:43:46', 1, 3, b'0'),
(319, 33, 32, 319, '2019-09-14', '02:43:46', 1, 3, b'0'),
(320, 33, 32, 320, '2019-09-14', '02:43:46', 1, 3, b'0'),
(321, 33, 32, 321, '2019-09-14', '02:43:46', 1, 3, b'0'),
(322, 33, 32, 322, '2019-09-14', '02:43:46', 1, 3, b'0'),
(323, 33, 32, 323, '2019-09-14', '02:43:46', 1, 3, b'0'),
(324, 33, 32, 324, '2019-09-14', '02:43:46', 1, 3, b'0'),
(325, 33, 32, 325, '2019-09-14', '02:43:46', 1, 3, b'0'),
(326, 33, 32, 326, '2019-09-14', '02:43:46', 1, 3, b'0'),
(327, 33, 32, 327, '2019-09-14', '02:43:46', 1, 3, b'0'),
(328, 33, 32, 328, '2019-09-14', '02:43:46', 1, 3, b'0'),
(329, 33, 32, 329, '2019-09-14', '02:43:46', 1, 3, b'0'),
(330, 33, 32, 330, '2019-09-14', '02:43:46', 1, 3, b'0'),
(331, 33, 32, 331, '2019-09-14', '02:43:46', 1, 3, b'0'),
(332, 33, 32, 332, '2019-09-14', '02:43:46', 1, 3, b'0'),
(333, 33, 32, 333, '2019-09-14', '02:43:46', 1, 3, b'0'),
(334, 33, 32, 334, '2019-09-14', '02:43:46', 1, 3, b'0'),
(335, 33, 32, 335, '2019-09-14', '02:43:46', 1, 3, b'0'),
(336, 33, 32, 336, '2019-09-14', '02:43:46', 1, 3, b'0'),
(337, 33, 32, 337, '2019-09-14', '02:43:46', 1, 3, b'0'),
(338, 33, 32, 338, '2019-09-14', '02:43:46', 1, 3, b'0'),
(339, 33, 32, 339, '2019-09-14', '02:43:46', 1, 3, b'0'),
(340, 33, 32, 340, '2019-09-14', '02:43:46', 1, 3, b'0'),
(341, 33, 32, 341, '2019-09-14', '02:43:46', 1, 3, b'0'),
(342, 33, 32, 342, '2019-09-14', '02:43:46', 1, 3, b'0'),
(343, 33, 32, 343, '2019-09-14', '02:43:46', 1, 3, b'0'),
(344, 33, 32, 344, '2019-09-14', '02:43:46', 1, 3, b'0'),
(345, 33, 32, 345, '2019-09-14', '02:43:46', 1, 3, b'0'),
(346, 33, 32, 346, '2019-09-14', '02:43:46', 1, 3, b'0'),
(347, 33, 32, 347, '2019-09-14', '02:43:46', 1, 3, b'0'),
(348, 33, 32, 348, '2019-09-14', '02:43:46', 1, 3, b'0'),
(349, 33, 32, 349, '2019-09-14', '02:43:46', 1, 3, b'0'),
(350, 33, 32, 350, '2019-09-14', '02:43:46', 1, 3, b'0'),
(351, 33, 32, 351, '2019-09-14', '02:43:46', 1, 3, b'0'),
(352, 33, 32, 352, '2019-09-14', '02:43:46', 1, 3, b'0'),
(353, 33, 32, 353, '2019-09-14', '02:43:46', 1, 3, b'0'),
(354, 33, 32, 354, '2019-09-14', '02:43:46', 1, 3, b'0'),
(355, 33, 32, 355, '2019-09-14', '02:43:46', 1, 3, b'0'),
(356, 33, 32, 356, '2019-09-14', '02:43:46', 1, 3, b'0'),
(357, 33, 32, 357, '2019-09-14', '02:43:46', 1, 3, b'0'),
(358, 33, 32, 358, '2019-09-14', '02:43:46', 1, 3, b'0'),
(359, 33, 32, 359, '2019-09-14', '02:43:46', 1, 3, b'0'),
(360, 33, 32, 360, '2019-09-14', '02:43:46', 1, 3, b'0'),
(361, 33, 32, 361, '2019-09-14', '02:43:46', 1, 3, b'0'),
(362, 33, 32, 362, '2019-09-14', '02:43:46', 1, 3, b'0'),
(363, 33, 32, 363, '2019-09-14', '02:43:46', 1, 3, b'0'),
(364, 33, 32, 364, '2019-09-14', '02:43:46', 1, 3, b'0'),
(365, 33, 32, 365, '2019-09-14', '02:43:46', 1, 3, b'0'),
(366, 33, 32, 366, '2019-09-14', '02:43:46', 1, 3, b'0'),
(367, 33, 32, 367, '2019-09-14', '02:43:46', 1, 3, b'0'),
(368, 33, 32, 368, '2019-09-14', '02:43:46', 1, 3, b'0'),
(369, 33, 32, 369, '2019-09-14', '02:43:46', 1, 3, b'0'),
(370, 33, 32, 370, '2019-09-14', '02:43:46', 1, 3, b'0'),
(371, 33, 32, 371, '2019-09-14', '02:43:46', 1, 3, b'0'),
(372, 33, 32, 372, '2019-09-14', '02:43:46', 1, 3, b'0'),
(373, 33, 32, 373, '2019-09-14', '02:43:46', 1, 3, b'0'),
(374, 33, 32, 374, '2019-09-14', '02:43:46', 1, 3, b'0'),
(375, 33, 32, 375, '2019-09-14', '02:43:46', 1, 3, b'0'),
(376, 33, 32, 376, '2019-09-14', '02:43:46', 1, 3, b'0'),
(377, 33, 32, 377, '2019-09-14', '02:43:46', 1, 3, b'0'),
(378, 33, 32, 378, '2019-09-14', '02:43:46', 1, 3, b'0'),
(379, 33, 32, 379, '2019-09-14', '02:43:46', 1, 3, b'0'),
(380, 33, 32, 380, '2019-09-14', '02:43:46', 1, 3, b'0'),
(381, 33, 32, 381, '2019-09-14', '02:43:46', 1, 3, b'0'),
(382, 33, 32, 382, '2019-09-14', '02:43:46', 1, 3, b'0'),
(383, 33, 32, 383, '2019-09-14', '02:43:46', 1, 3, b'0'),
(384, 33, 32, 384, '2019-09-14', '02:43:46', 1, 3, b'0'),
(385, 33, 32, 385, '2019-09-14', '02:43:46', 1, 3, b'0'),
(386, 33, 32, 386, '2019-09-14', '02:43:46', 1, 3, b'0'),
(387, 33, 32, 387, '2019-09-14', '02:43:46', 1, 3, b'0'),
(388, 33, 32, 388, '2019-09-14', '02:43:46', 1, 3, b'0'),
(389, 33, 32, 389, '2019-09-14', '02:43:46', 1, 3, b'0'),
(390, 33, 32, 390, '2019-09-14', '02:43:46', 1, 3, b'0'),
(391, 33, 32, 391, '2019-09-14', '02:43:46', 1, 3, b'0'),
(392, 33, 32, 392, '2019-09-14', '02:43:46', 1, 3, b'0'),
(393, 33, 32, 393, '2019-09-14', '02:43:46', 1, 3, b'0'),
(394, 33, 32, 394, '2019-09-14', '02:43:46', 1, 3, b'0'),
(395, 33, 32, 395, '2019-09-14', '02:43:46', 1, 3, b'0'),
(396, 33, 32, 396, '2019-09-14', '02:43:46', 1, 3, b'0'),
(397, 33, 32, 397, '2019-09-14', '02:43:46', 1, 3, b'0'),
(398, 33, 32, 398, '2019-09-14', '02:43:46', 1, 3, b'0'),
(399, 33, 32, 399, '2019-09-14', '02:43:46', 1, 3, b'0'),
(400, 33, 32, 400, '2019-09-14', '02:43:46', 1, 3, b'0'),
(401, 33, 32, 401, '2019-09-14', '02:43:46', 1, 3, b'0'),
(402, 33, 32, 402, '2019-09-14', '02:43:46', 1, 3, b'0'),
(403, 33, 32, 403, '2019-09-14', '02:43:46', 1, 3, b'0'),
(404, 33, 32, 404, '2019-09-14', '02:43:46', 1, 3, b'0'),
(405, 33, 32, 405, '2019-09-14', '02:43:46', 1, 3, b'0'),
(406, 33, 32, 406, '2019-09-14', '02:43:46', 1, 3, b'0'),
(407, 33, 32, 407, '2019-09-14', '02:43:46', 1, 3, b'0'),
(408, 33, 32, 408, '2019-09-14', '02:43:46', 1, 3, b'0'),
(409, 33, 32, 409, '2019-09-14', '02:43:46', 1, 3, b'0'),
(410, 33, 32, 410, '2019-09-14', '02:43:46', 1, 3, b'0'),
(411, 33, 32, 411, '2019-09-14', '02:43:46', 1, 3, b'0'),
(412, 33, 32, 412, '2019-09-14', '02:43:46', 1, 3, b'0'),
(413, 33, 32, 413, '2019-09-14', '02:43:46', 1, 3, b'0'),
(414, 33, 32, 414, '2019-09-14', '02:43:46', 1, 3, b'0'),
(415, 33, 32, 415, '2019-09-14', '02:43:46', 1, 3, b'0'),
(416, 33, 32, 416, '2019-09-14', '02:43:46', 1, 3, b'0'),
(417, 33, 32, 417, '2019-09-14', '02:43:46', 1, 3, b'0'),
(418, 33, 32, 418, '2019-09-14', '02:43:46', 1, 3, b'0'),
(419, 33, 32, 419, '2019-09-14', '02:43:46', 1, 3, b'0'),
(420, 33, 32, 420, '2019-09-14', '02:43:46', 1, 3, b'0'),
(421, 33, 32, 421, '2019-09-14', '02:43:46', 1, 3, b'0'),
(422, 33, 32, 422, '2019-09-14', '02:43:46', 1, 3, b'0'),
(423, 33, 32, 423, '2019-09-14', '02:43:46', 1, 3, b'0'),
(424, 33, 32, 424, '2019-09-14', '02:43:46', 1, 3, b'0'),
(425, 33, 32, 425, '2019-09-14', '02:43:46', 1, 3, b'0'),
(426, 33, 32, 426, '2019-09-14', '02:43:46', 1, 3, b'0'),
(427, 33, 32, 427, '2019-09-14', '02:43:46', 1, 3, b'0'),
(428, 33, 32, 428, '2019-09-14', '02:43:46', 1, 3, b'0'),
(429, 33, 32, 429, '2019-09-14', '02:43:46', 1, 3, b'0'),
(430, 33, 32, 430, '2019-09-14', '02:43:46', 1, 3, b'0'),
(431, 33, 32, 431, '2019-09-14', '02:43:46', 1, 3, b'0'),
(432, 33, 32, 432, '2019-09-14', '02:43:46', 1, 3, b'0'),
(433, 33, 32, 433, '2019-09-14', '02:43:46', 1, 3, b'0'),
(434, 33, 32, 434, '2019-09-14', '02:43:46', 1, 3, b'0'),
(435, 33, 32, 435, '2019-09-14', '02:43:46', 1, 3, b'0'),
(436, 33, 32, 436, '2019-09-14', '02:43:46', 1, 3, b'0'),
(437, 33, 32, 437, '2019-09-14', '02:43:46', 1, 3, b'0'),
(438, 33, 32, 438, '2019-09-14', '02:43:46', 1, 3, b'0'),
(439, 33, 32, 439, '2019-09-14', '02:43:46', 1, 3, b'0'),
(440, 33, 32, 440, '2019-09-14', '02:43:46', 1, 3, b'0'),
(441, 33, 32, 441, '2019-09-14', '02:43:46', 1, 3, b'0'),
(442, 33, 32, 442, '2019-09-14', '02:43:46', 1, 3, b'0'),
(443, 33, 32, 443, '2019-09-14', '02:43:46', 1, 3, b'0'),
(444, 33, 32, 444, '2019-09-14', '02:43:46', 1, 3, b'0'),
(445, 33, 32, 445, '2019-09-14', '02:43:46', 1, 3, b'0'),
(446, 33, 32, 446, '2019-09-14', '02:43:46', 1, 3, b'0'),
(447, 33, 32, 447, '2019-09-14', '02:43:46', 1, 3, b'0'),
(448, 33, 32, 448, '2019-09-14', '02:43:46', 1, 3, b'0'),
(449, 33, 32, 449, '2019-09-14', '02:43:46', 1, 3, b'0'),
(450, 33, 32, 450, '2019-09-14', '02:43:46', 1, 3, b'0'),
(451, 40, 35, 451, '2019-09-17', '05:03:00', 26, 3, b'0'),
(452, 40, 35, 452, '2019-09-17', '05:06:00', 7, 3, b'0'),
(453, 40, 35, 453, '2019-09-17', '05:09:00', 41, 3, b'0'),
(454, 40, 35, 454, '2019-09-17', '05:05:00', 7, 3, b'0'),
(455, 40, 35, 455, '2019-09-17', '05:03:00', 35, 3, b'0'),
(456, 40, 35, 456, '2019-09-17', '03:16:59', 1, 3, b'0'),
(457, 40, 35, 457, '2019-09-17', '05:45:00', 31, 3, b'0'),
(458, 40, 35, 458, '2019-09-17', '03:16:59', 1, 3, b'0'),
(459, 40, 35, 459, '2019-09-17', '03:16:59', 1, 3, b'0'),
(460, 40, 35, 460, '2019-09-17', '03:16:59', 1, 3, b'0'),
(461, 39, 35, 461, '2019-09-18', '12:09:00', 15, 3, b'0'),
(462, 39, 35, 462, '2019-09-18', '04:46:00', 25, 3, b'0'),
(463, 39, 35, 463, '2019-09-17', '03:56:00', 35, 3, b'0'),
(464, 39, 35, 464, '2019-09-18', '12:09:00', 15, 3, b'0'),
(465, 39, 35, 465, '2019-09-17', '04:48:00', 27, 3, b'0'),
(466, 39, 35, 466, '2019-09-17', '03:59:00', 7, 3, b'0'),
(467, 39, 35, 467, '2019-09-17', '03:55:00', 39, 3, b'0'),
(468, 39, 35, 468, '2019-09-17', '03:56:00', 36, 3, b'0'),
(469, 39, 35, 469, '2019-09-17', '03:57:00', 25, 3, b'0'),
(470, 39, 35, 470, '2019-09-18', '12:10:00', 15, 3, b'0'),
(471, 38, 35, 471, '2019-09-17', '03:17:13', 1, 3, b'0'),
(472, 38, 35, 472, '2019-09-17', '03:17:13', 1, 3, b'0'),
(473, 38, 35, 473, '2019-09-17', '03:17:13', 1, 3, b'0'),
(474, 38, 35, 474, '2019-09-17', '03:17:13', 1, 3, b'0'),
(475, 38, 35, 475, '2019-09-17', '03:17:13', 1, 3, b'0'),
(476, 38, 35, 476, '2019-09-17', '03:17:13', 1, 3, b'0'),
(477, 38, 35, 477, '2019-09-17', '03:17:13', 1, 3, b'0'),
(478, 38, 35, 478, '2019-09-17', '03:17:13', 1, 3, b'0'),
(479, 38, 35, 479, '2019-09-17', '03:17:13', 1, 3, b'0'),
(480, 38, 35, 480, '2019-09-17', '03:17:13', 1, 3, b'0'),
(481, 32, NULL, 481, '2019-09-28', '01:30:51', 1, 3, b'1'),
(482, 36, 32, 482, '2019-09-17', '03:27:00', 15, 3, b'0'),
(483, 39, 35, 483, '2019-09-17', '03:35:00', 4, 3, b'0'),
(484, 36, 32, 484, '2019-09-17', '03:31:00', 31, 3, b'0'),
(485, 36, 32, 485, '2019-09-17', '03:28:00', 32, 3, b'0'),
(486, 36, 32, 486, '2019-09-17', '03:30:00', 35, 3, b'0'),
(487, 36, 32, 487, '2019-09-17', '03:29:00', 33, 3, b'0'),
(488, 36, 32, 488, '2019-09-17', '03:17:21', 1, 3, b'0'),
(489, 36, 32, 489, '2019-09-17', '03:17:21', 1, 3, b'0'),
(491, 35, NULL, 491, '2019-09-17', '03:17:30', 1, 3, b'0'),
(492, 35, NULL, 492, '2019-09-17', '03:17:30', 1, 3, b'0'),
(493, 35, NULL, 493, '2019-09-17', '03:17:30', 1, 3, b'0'),
(494, 35, NULL, 494, '2019-09-17', '03:17:30', 1, 3, b'0'),
(495, 35, NULL, 495, '2019-09-17', '03:17:30', 1, 3, b'0'),
(496, 35, NULL, 496, '2019-09-17', '03:17:30', 1, 3, b'0'),
(497, 35, NULL, 497, '2019-09-17', '03:17:30', 1, 3, b'0'),
(498, 35, NULL, 498, '2019-09-17', '03:17:30', 1, 3, b'0'),
(499, 35, NULL, 499, '2019-09-17', '03:17:30', 1, 3, b'0'),
(500, 35, NULL, 500, '2019-09-17', '03:17:30', 1, 3, b'0'),
(501, 34, NULL, 501, '2019-09-17', '03:17:38', 1, 3, b'0'),
(502, 34, NULL, 502, '2019-09-17', '03:17:38', 1, 3, b'0'),
(503, 34, NULL, 503, '2019-09-17', '03:17:38', 1, 3, b'0'),
(504, 34, NULL, 504, '2019-09-17', '03:17:38', 1, 3, b'0'),
(505, 34, NULL, 505, '2019-09-17', '03:17:38', 1, 3, b'0'),
(506, 34, NULL, 506, '2019-09-17', '03:17:38', 1, 3, b'0'),
(507, 34, NULL, 507, '2019-09-17', '03:17:38', 1, 3, b'0'),
(508, 34, NULL, 508, '2019-09-17', '03:17:38', 1, 3, b'0'),
(509, 34, NULL, 509, '2019-09-17', '03:17:38', 1, 3, b'0'),
(510, 34, NULL, 510, '2019-09-17', '03:17:38', 1, 3, b'0');

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
(1, 4, 'File_28-09-201915697048110.PNG'),
(2, 4, 'File_28-09-201915697048111.jpg'),
(3, 4, 'File_28-09-201915697048112.pdf'),
(4, 4, 'File_28-09-201915697048113.pdf'),
(5, 5, 'File_28-09-201915697049600.PNG'),
(6, 5, 'File_28-09-201915697049601.jpg'),
(7, 5, 'File_28-09-201915697049602.pdf'),
(8, 5, 'File_28-09-201915697049603.pdf'),
(9, 9, 'File_30-09-201915698754220.pdf'),
(10, 9, 'File_30-09-201915698754221.jpg'),
(11, 9, 'File_30-09-201915698754222.PNG'),
(12, 24, 'File_30-09-201915698789430.pdf'),
(13, 24, 'File_30-09-201915698789431.jpg'),
(14, 24, 'File_30-09-201915698789432.PNG'),
(15, 25, 'File_30-09-201915698793940.pdf'),
(16, 26, 'File_01-10-201915698812150.pdf'),
(17, 26, 'File_01-10-201915698812151.PNG'),
(18, 26, 'File_01-10-201915698812152.PNG'),
(19, 27, 'File_01-10-201915698812150.pdf'),
(20, 27, 'File_01-10-201915698812151.PNG'),
(21, 27, 'File_01-10-201915698812152.PNG'),
(22, 28, 'File_01-10-201915698812150.pdf'),
(23, 28, 'File_01-10-201915698812151.PNG'),
(24, 28, 'File_01-10-201915698812152.PNG'),
(25, 29, 'File_01-10-201915698815060.PNG'),
(26, 30, 'File_01-10-201915698815060.PNG'),
(27, 31, 'File_01-10-201915698815060.PNG');

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

--
-- Dumping data for table `messagecrm`
--

INSERT INTO `messagecrm` (`CrmMessagesId`, `CrmMessagesFrom`, `CrmMessagesTo`, `CrmMessagesCustomer`, `CrmMessagesTitle`, `CrmMessagesContent`, `CrmMessagesType`, `CrmMessagesCreateDate`, `CrmMessagesUpdateDate`, `subjectid`, `complain`, `active`) VALUES
(1, 29, 0, 0, 'test message', '123', 2, '2019-09-13 18:04:52', '2019-09-13 18:04:52', 0, 1, 1),
(6, 3, 0, 0, 'test message', '123', 2, '2019-09-13 19:44:39', '2019-09-13 19:44:39', 0, 1, 1),
(7, 3, 0, 0, 'test message', '12312', 2, '2019-09-13 19:51:51', '2019-09-13 19:51:51', 0, 1, 1),
(8, 3, 0, 4, 'Test', '6666', 2, '2019-09-13 19:52:27', '2019-09-13 19:52:27', 0, 1, 1),
(9, 3, 0, 4, 'Test', '6666', 2, '2019-09-13 19:52:46', '2019-09-13 19:52:46', 0, 1, 1),
(11, 33, 0, 0, 'يفغاف', '', 2, '2019-09-16 15:38:01', '2019-09-16 15:38:01', 0, 1, 1),
(12, 33, 0, 0, 'يفغاف', '', 2, '2019-09-16 15:38:02', '2019-09-16 15:38:02', 0, 1, 1),
(13, 33, 0, 0, 'يفغاف', '', 2, '2019-09-16 15:38:03', '2019-09-16 15:38:03', 0, 1, 1),
(14, 33, 0, 0, 'يفغاف', '', 2, '2019-09-16 15:38:04', '2019-09-16 15:38:04', 0, 1, 1),
(15, 33, 0, 0, 'يفغاف', '', 2, '2019-09-16 15:38:05', '2019-09-16 15:38:05', 0, 1, 1),
(16, 33, 0, 0, 'يفغاف', '', 2, '2019-09-16 15:38:17', '2019-09-16 15:38:17', 0, 1, 1),
(17, 33, 0, 0, 'الاا', '', 2, '2019-09-16 15:39:23', '2019-09-16 15:39:23', 0, 1, 1),
(18, 33, 0, 0, 'الاا', '', 2, '2019-09-16 15:39:33', '2019-09-16 15:39:33', 0, 1, 1),
(19, 33, 0, 0, 'الاا', '', 2, '2019-09-16 15:39:46', '2019-09-16 15:39:46', 0, 1, 1),
(20, 33, 0, 0, 'الاا', 'nn', 2, '2019-09-16 15:39:57', '2019-09-16 15:39:57', 0, 1, 1),
(21, 33, 0, 0, 'الاا', 'nn', 2, '2019-09-16 15:40:20', '2019-09-16 15:40:20', 0, 1, 1),
(22, 3, 0, 0, 'test message', '123', 2, '2019-09-16 15:59:20', '2019-09-16 15:59:20', 0, 1, 1),
(23, 33, 0, 0, '123', '123', 2, '2019-09-16 16:32:55', '2019-09-16 16:32:55', 0, 1, 1),
(24, 39, 0, 461, 'test', 'CRM test', 2, '2019-09-18 12:21:29', '2019-09-18 12:21:29', 0, 1, 1),
(25, 39, 0, 462, 'test', 'CRM test', 2, '2019-09-18 12:21:29', '2019-09-18 12:21:29', 0, 1, 1),
(27, 39, 0, 461, 'test', 'CRM test', 2, '2019-09-18 12:24:37', '2019-09-18 12:24:37', 0, 1, 1),
(28, 39, 0, 462, 'test', 'CRM test', 2, '2019-09-18 12:24:37', '2019-09-18 12:24:37', 0, 1, 1),
(30, 39, 0, 461, 'test', 'CRM test', 2, '2019-09-18 12:27:44', '2019-09-18 12:27:44', 0, 1, 1),
(31, 39, 0, 462, 'test', 'CRM test', 2, '2019-09-18 12:27:47', '2019-09-18 12:27:47', 0, 1, 1),
(33, 39, 0, 461, 'test 2', 'CRM test 2 ', 2, '2019-09-18 12:28:33', '2019-09-18 12:28:33', 0, 1, 1),
(34, 39, 0, 462, 'test 2', 'CRM test 2 ', 2, '2019-09-18 12:28:35', '2019-09-18 12:28:35', 0, 1, 1),
(36, 39, 0, 0, 'abdob2623@gmail.com', '234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432', 2, '2019-09-18 12:59:32', '2019-09-18 12:59:32', 0, 1, 1),
(37, 39, 0, 0, 'abdob2623@gmail.com', '234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432', 2, '2019-09-18 12:59:50', '2019-09-18 12:59:50', 0, 1, 1),
(38, 39, 0, 0, 'abdob2623@gmail.com', '234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432234567898765432', 2, '2019-09-18 13:00:18', '2019-09-18 13:00:18', 0, 1, 1),
(39, 39, 0, 462, 'Test', 'test123', 2, '2019-09-18 14:49:37', '2019-09-18 14:49:37', 0, 1, 1),
(40, 39, 0, 462, 'Test', 'test', 2, '2019-09-18 15:04:08', '2019-09-18 15:04:08', 0, 1, 1),
(41, 39, 0, 462, 'Test', 'test', 2, '2019-09-18 15:06:59', '2019-09-18 15:06:59', 0, 1, 1),
(42, 39, 0, 462, 'Test', 'test', 2, '2019-09-18 15:07:23', '2019-09-18 15:07:23', 0, 1, 1),
(43, 39, 0, 462, 'Test', 'test', 2, '2019-09-18 15:07:43', '2019-09-18 15:07:43', 0, 1, 1),
(44, 39, 0, 462, 'Test', 'rrr', 2, '2019-09-18 15:08:12', '2019-09-18 15:08:12', 0, 1, 1),
(45, 39, 0, 462, 'Test', 'rrr', 2, '2019-09-18 15:09:58', '2019-09-18 15:09:58', 0, 1, 1),
(46, 39, 0, 462, 'Test', 'rrr', 2, '2019-09-18 15:10:56', '2019-09-18 15:10:56', 0, 1, 1),
(47, 39, 0, 462, 'Test', 'rrr', 2, '2019-09-18 15:13:58', '2019-09-18 15:13:58', 0, 1, 1),
(48, 39, 0, 462, 'Test', 'rrr', 2, '2019-09-18 15:14:13', '2019-09-18 15:14:13', 0, 1, 1),
(49, 39, 0, 462, 'Test', 'rrr', 2, '2019-09-18 15:15:31', '2019-09-18 15:15:31', 0, 1, 1),
(50, 3, 0, 11, 'test1', 'test', 2, '2019-09-26 14:41:56', '2019-09-26 14:41:56', 0, 1, 1),
(51, 3, 0, 11, 'test5', 'asd', 2, '2019-09-26 14:48:37', '2019-09-26 14:48:37', 0, 1, 1),
(52, 3, 0, 11, 'test6', 'resr', 2, '2019-09-26 14:50:09', '2019-09-26 14:50:09', 0, 1, 1),
(53, 3, 0, 11, 'test6', 'resr', 2, '2019-09-26 14:50:10', '2019-09-26 14:50:10', 0, 1, 1),
(54, 3, 0, 11, 'test6', 'resr', 2, '2019-09-26 14:50:33', '2019-09-26 14:50:33', 0, 1, 1);

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
  `loginbg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settingcrm`
--

INSERT INTO `settingcrm` (`settingcrmId`, `settingcrmTimeMinute`, `settimgcrmType`, `settingcrmName`, `settingcrmPhone`, `settingcrmFax`, `settingcrmEmail`, `settingcrmAddress`, `settingcrmSite`, `settingcrmCreateDate`, `settingcrmUpdateDate`, `settingcrmLogo`, `loginbg`) VALUES
(1, 30, 0, 'CRM', '01098015152', '333', 'CRM@gmail.com', '4 St', 'www.crm.com', '2018-03-12 11:32:14', '2018-03-12 11:32:14', '1568817652.png', 'pexels-photo-990818.jpeg');

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
(5, 32, '', '123', '', '587'),
(6, 33, '', '123', '', '587'),
(7, 34, '', '12345', '', '587'),
(8, 35, '', '12345', '', '587'),
(9, 36, '', '12345', '', '587'),
(10, 37, '', '12345', '', '587'),
(11, 38, '', '12345', '', '587'),
(12, 39, '', '', '', '587'),
(13, 40, '', '12345', '', '587'),
(15, 42, '', '123', '', '587');

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
(3, 3, 0, 0, b'0', b'0', 0, 0),
(4, 33, 0, 0, b'0', b'0', 6, 0),
(5, 32, 0, 0, b'0', b'0', 4, 0),
(6, 36, 0, 0, b'0', b'0', 1, 0),
(7, 39, 0, 0, b'0', b'0', 5, 0),
(8, 40, 0, 0, b'0', b'0', 0, 0);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `client_orders_details`
--
ALTER TABLE `client_orders_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `client_payments`
--
ALTER TABLE `client_payments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `communication_settings`
--
ALTER TABLE `communication_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `complaints_details`
--
ALTER TABLE `complaints_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `crm_calls`
--
ALTER TABLE `crm_calls`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `crm_call_notifications`
--
ALTER TABLE `crm_call_notifications`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `crm_comments`
--
ALTER TABLE `crm_comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `crm_follows`
--
ALTER TABLE `crm_follows`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `crm_messages`
--
ALTER TABLE `crm_messages`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `crm_messages_details`
--
ALTER TABLE `crm_messages_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `crm_messages_users`
--
ALTER TABLE `crm_messages_users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `crm_sms`
--
ALTER TABLE `crm_sms`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `crm_transfer_type`
--
ALTER TABLE `crm_transfer_type`
  MODIFY `transfer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `crm_users`
--
ALTER TABLE `crm_users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `crm_userstypes`
--
ALTER TABLE `crm_userstypes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `crm_users_log`
--
ALTER TABLE `crm_users_log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `crm_users_permissions`
--
ALTER TABLE `crm_users_permissions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=545;

--
-- AUTO_INCREMENT for table `customercrm`
--
ALTER TABLE `customercrm`
  MODIFY `customerCrmId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=642;

--
-- AUTO_INCREMENT for table `customerproductcrm`
--
ALTER TABLE `customerproductcrm`
  MODIFY `customerProductId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees_tasks`
--
ALTER TABLE `employees_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=511;

--
-- AUTO_INCREMENT for table `mailattachs`
--
ALTER TABLE `mailattachs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `messagecrm`
--
ALTER TABLE `messagecrm`
  MODIFY `CrmMessagesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  ADD CONSTRAINT `mailattachs_ibfk_1` FOREIGN KEY (`MailID`) REFERENCES `crm_mails` (`ID`);

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

CREATE DEFINER=`root`@`localhost` EVENT `Every_Minute_Insert_Delayed_Calls` ON SCHEDULE EVERY 1 MINUTE STARTS '2019-02-11 16:19:14' ON COMPLETION NOT PRESERVE ENABLE DO INSERT into user_messages(userID,Delayed_Calls)
select * from (select Users.UID as userID,(CASE WHEN callcount.cCount IS NULL THEN 0 ELSE callcount.cCount END) as Delayed_Calls from
 (select DISTINCT(userID) AS UID FROM crm_follows) as Users 
 LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 crm_follows WHERE crm_follows.Follow_Date = date(now()) 
 AND (time(DATE_ADD(crm_follows.Follow_Time,INTERVAL 15 MINUTE)) >= time(now()) 
 And crm_follows.Follow_Time < time(now())) GROUP By userID) as callcount 
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

CREATE DEFINER=`root`@`localhost` EVENT `Every_Minute_Insetr_UpcommingCalls` ON SCHEDULE EVERY 1 MINUTE STARTS '2019-02-11 16:08:37' ON COMPLETION NOT PRESERVE ENABLE DO INSERT into user_messages(userID,UpcommingCalls)
select * from (select Users.UID as userID,(CASE WHEN callcount.cCount IS NULL THEN 0 ELSE callcount.cCount END) as UpcommingCalls from
 (select DISTINCT(userID) AS UID FROM crm_follows) as Users 
 LEFT JOIN (SELECT userID , COUNT(*) as cCount FROM 
 crm_follows WHERE crm_follows.Follow_Date = date(now()) 
 AND (crm_follows.Follow_Time <= time(DATE_ADD(now(),INTERVAL 15 MINUTE)) 
 And crm_follows.Follow_Time > time(now())) GROUP By userID) as callcount 
 on Users.UID = callcount.userID ) as userCallCount
 WHERE  userCallCount.userID NOT in (select userID FROM user_messages)$$

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

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
