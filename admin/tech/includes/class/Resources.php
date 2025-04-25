<?php

namespace Admin\Tech\Includes\Class;

use PDO;
use PDOException;

class Resources
{
    private $conn;
    private $table = "fm_resources";
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        $q = "SELECT * 
                FROM {$this->table} 
                ORDER BY id DESC";
        $stmt = $this->conn->prepare($q);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_BOTH);
    }


    public function getAllRequest()
    {
        $q = "SELECT r.name, r.quantity, rq.status, rq.requested_at  
                FROM fm_resource_requests rq
                JOIN fm_resources r ON rq.resource_id = r.id;";
        $stmt = $this->conn->prepare($q);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_BOTH);
    }

    public function create_resource($data)
    {
        $q = "INSERT INTO {$this->table}(name, category, quantity, status, next_maintenance, last_maintenance, location) 
        VALUES(:name, :category, :quantity, :status, :next_maintenance, :last_maintenance, :location) ";
        $stmt = $this->conn->prepare($q);
        return $stmt->execute($data);
    }

    public function update_resource($id, $data)
    {
        $q = "UPDATE fm_resources 
            SET 
                name = :name, 
                category = :category, 
                quantity = :quantity, 
                location = :location, 
                status = :status, 
                last_maintenance = :last_maintenance, 
                next_maintenance = :next_maintenance
            WHERE id = :id";

        $data[':id'] = $id; // Add the ID to the data array
        $stmt = $this->conn->prepare($q);
        return $stmt->execute($data); // Pass only the $data array to execute()
    }

    public function updateAllocationStatus($id)
    {
        $q = "UPDATE fm_resource_allocations 
            SET 
                status = 'Returned'
            WHERE id = :id";

        $stmt = $this->conn->prepare($q);
        return $stmt->execute(['id' => $id]);
    }

    public function delete_asset($id)
    {
        try {
            $q = "DELETE FROM {$this->table} WHERE id=:id";
            $stmt = $this->conn->prepare($q);
            return $stmt->execute(['id' => $id]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAvailableResource()
    {
        try {
            $q = "SELECT id ,name ,quantity
            FROM {$this->table}
            WHERE status = 'Available'; ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function requestResource($data)
    {
        try {
            $query = "SELECT quantity FROM fm_resources WHERE id = :resource_id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':resource_id' => $data['resource_id']]);
            $resource = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$resource || $resource['quantity'] < $data['quantity']) {
                return ['success' => false, 'message' => 'Requested quantity exceeds available stock.'];
            }

            $insertQuery = "
                INSERT INTO fm_resource_requests (resource_id, employee_id, quantity, purpose) 
                VALUES (:resource_id, :employee_id, :quantity, :purpose)
            ";
            $stmt = $this->conn->prepare($insertQuery);
            $stmt->execute([
                ':resource_id' => $data['resource_id'],
                ':employee_id' => $data['employee_id'],
                ':quantity' => $data['quantity'],
                ':purpose' => $data['purpose']
            ]);

            return ['success' => true, 'message' => 'Resource request submitted successfully.'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function PendingRequests()
    {
        try {

            $q = "SELECT rr.*, re.name , re.category, us.username 
                    FROM fm_resource_requests rr 
                    JOIN fm_resources re ON rr.resource_id = re.id 
                    JOIN users us ON rr.employee_id = us.id 
                    WHERE rr.status = 'Pending' || rr.status = 'Approved'; ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return 'Eror::' . $e->getMessage();
        }
    }

    public function updateRequestStatus($requestId, $status)
    {
        try {

            $query = "SELECT resource_id, quantity FROM fm_resource_requests WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':id' => $requestId]);
            $request = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$request) {
                return ['success' => false, 'message' => 'Request not found.'];
            }

            if ($status === 'Approved') {
                $query = "SELECT quantity FROM fm_resources WHERE id = :resource_id";
                $stmt = $this->conn->prepare($query);
                $stmt->execute([':resource_id' => $request['resource_id']]);
                $resource = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$resource || $resource['quantity'] < $request['quantity']) {
                    return ['success' => false, 'message' => 'Insufficient stock to approve this request.'];
                }

                // Deduct stock
                $updateStockQuery = "UPDATE fm_resources SET quantity = quantity - :quantity WHERE id = :resource_id";
                $stmt = $this->conn->prepare($updateStockQuery);
                $stmt->execute([
                    ':quantity' => $request['quantity'],
                    ':resource_id' => $request['resource_id']
                ]);
            }

            // Update request status
            $updateRequestQuery = "UPDATE fm_resource_requests SET status = :status, approved_at = NOW() WHERE id = :id";
            $stmt = $this->conn->prepare($updateRequestQuery);
            $stmt->execute([
                ':status' => $status,
                ':id' => $requestId
            ]);

            return ['success' => true, 'message' => "Request $status successfully."];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function allocateResource($data)
    {
        try {
            // Check if enough quantity is available
            $query = "SELECT quantity FROM fm_resources WHERE id = :resource_id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':resource_id' => $data['resource_id']]);
            $resource = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$resource || $resource['quantity'] < $data['quantity']) {
                return ['success' => false, 'message' => 'Insufficient stock for allocation.'];
            }

            // Deduct allocated quantity from stock
            $updateQuery = "UPDATE fm_resources SET quantity = quantity - :quantity WHERE id = :resource_id";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->execute([':quantity' => $data['quantity'], ':resource_id' => $data['resource_id']]);

            // Insert allocation record
            $insertQuery = "
            INSERT INTO fm_resource_allocations (resource_id, employee_id, quantity, allocation_start, allocation_end, status, notes) 
            VALUES (:resource_id, :employee_id, :quantity, :allocation_start, :allocation_end, :status, :notes)
        ";
            $stmt = $this->conn->prepare($insertQuery);
            $stmt->execute([
                ':resource_id' => $data['resource_id'],
                ':employee_id' => $data['employee_id'],
                ':quantity' => $data['quantity'],
                ':allocation_start' => $data['allocation_start'],
                ':allocation_end' => $data['allocation_end'] ?? null,
                ':status' => $data['status'] ?? 'allocated',
                ':notes' => $data['notes'] ?? null,
            ]);

            return ['success' => true, 'message' => 'Resource allocated successfully.'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function getAllocatedResources()
    {
        try {
            $q = "SELECT ra.* , fr.name as resource_name , us.username 
                FROM fm_resource_allocations ra 
                JOIN fm_resources fr ON ra.resource_id = fr.id 
                JOIN users us ON ra.employee_id = us.id 
                WHERE ra.status != 'Returned'
                ORDER BY ra.id DESC; ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllocatedResourcesLog()
    {
        try {
            $q = "SELECT ra.* , fr.name as resource_name , us.username 
                FROM fm_resource_allocations ra 
                JOIN fm_resources fr ON ra.resource_id = fr.id 
                JOIN users us ON ra.employee_id = us.id 
                ORDER BY ra.id DESC; ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function AllocationStatusUpdate($status, $allocationId)
    {
        try {
            $query = "UPDATE fm_resource_allocations SET status = :status WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([':status' => $status, ':id' => $allocationId]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllocatedResourcesByID($id)
    {
        try {
            $q = "SELECT fr.*  
                FROM fm_resources fr 
                WHERE id = :id;";
            $stmt = $this->conn->prepare($q);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function UsagePatterns()
    {
        try {
            $q = "SELECT 
                name as resource_name, 
                SUM(quantity) AS total_used 
                FROM fm_resources 
                GROUP BY name 
                ORDER BY total_used DESC; ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();

            $labels = [];
            $data = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $labels[] = $row['resource_name'];  // Resource names
                $data[] = $row['total_used'];      // Total usage for each resource
            }

            return [
                'labels' => $labels,
                'data' => $data
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function RequestTrend()
    {
        try {
            $q = "SELECT DATE(requested_at) AS date, 
                COUNT(*) AS total_requests 
                FROM fm_resource_requests 
                GROUP BY DATE(requested_at) 
                ORDER BY date; ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();

            $labels = [];
            $data = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $labels[] = $row['date'];  // Dates of requests
                $data[] = $row['total_requests']; // Total requests on that date
            }

            return [
                'labels' => $labels,
                'data' => $data
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUnusedResources()
    {
        try {
            $q = "SELECT fr.name AS resource_name, 
                         fr.quantity - SUM(ra.quantity) AS unused 
                  FROM fm_resources fr 
                  LEFT JOIN fm_resource_allocations ra ON fr.id = ra.resource_id 
                  GROUP BY resource_name 
                  HAVING unused > 0
                  ORDER BY unused DESC;";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();

            $resources = [];
            $unusedQuantities = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resources[] = $row['resource_name'];
                $unusedQuantities[] = $row['unused'];
            }

            return [
                'labels' => $resources,
                'data' => $unusedQuantities,
            ];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function OverutilizedResources()
    {
        try {
            $q = "SELECT 
                fr.name AS resource_name, 
                SUM(ra.quantity) - fr.quantity AS overused 
              FROM 
                fm_resources fr 
              JOIN 
                fm_resource_allocations ra 
              ON 
                fr.id = ra.resource_id 
              GROUP BY 
                fr.id, fr.name 
              HAVING 
                overused > 0 
              ORDER BY 
                overused DESC;";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();

            $resources = [];
            $overutilizedQuantities = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resources[] = $row['resource_name'];
                $overutilizedQuantities[] = $row['overutilized'];
            }

            return [
                'labels' => $resources,
                'data' => $overutilizedQuantities,
            ];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function CategorizedResources()
    {
        try {
            $q = "SELECT category, 
                    name AS resource_name, 
                    fr.quantity AS total_available, 
                    IFNULL(SUM(ra.quantity), 0) AS total_allocated, 
                    (fr.quantity - IFNULL(SUM(ra.quantity), 0)) AS unused 
                    FROM fm_resources fr 
                    LEFT JOIN fm_resource_allocations ra ON fr.id = ra.resource_id 
                    GROUP BY category, resource_name 
                    ORDER BY category, resource_name;";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function returnResource($request_id)
    {
        try {
            $this->conn->beginTransaction();

            // ✅ Get the requested quantity and resource_id first
            $getQuantityQuery = "SELECT resource_id, quantity 
                                 FROM fm_resource_requests 
                                 WHERE id = :request_id";
            $stmt0 = $this->conn->prepare($getQuantityQuery);
            $stmt0->bindParam(":request_id", $request_id, PDO::PARAM_INT);
            $stmt0->execute();
            $requestData = $stmt0->fetch(PDO::FETCH_ASSOC);

            if (!$requestData) {
                throw new Exception("Request ID not found.");
            }

            $resource_id = $requestData['resource_id'];
            $requested_quantity = $requestData['quantity']; // Quantity to return

            // ✅ Update the request status to 'Returned' and set return_date
            $updateRequestQuery = "UPDATE fm_resource_requests 
                                   SET status = 'Returned', return_date = NOW() 
                                   WHERE id = :request_id";
            $stmt1 = $this->conn->prepare($updateRequestQuery);
            $stmt1->bindParam(":request_id", $request_id, PDO::PARAM_INT);
            $stmt1->execute();

            // ✅ Update the resource quantity by adding back the requested amount
            $updateResourceQuery = "UPDATE fm_resources 
                                    SET quantity = quantity + :requested_quantity, 
                                        status = 'Available' 
                                    WHERE id = :resource_id";
            $stmt2 = $this->conn->prepare($updateResourceQuery);
            $stmt2->bindParam(":requested_quantity", $requested_quantity, PDO::PARAM_INT);
            $stmt2->bindParam(":resource_id", $resource_id, PDO::PARAM_INT);
            $stmt2->execute();

            $this->conn->commit();
            return ["success" => true, "message" => "Resource returned successfully!"];
        } catch (Exception $e) {
            $this->conn->rollBack();
            return ["success" => false, "message" => $e->getMessage()];
        }
    }


    public function get_employee_for_allocation()
    {
        try {
            $q = "SELECT * FROM employees";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $employees;
        } catch (PDOException $e) {
            return "Something went wrong" . $e;
        }
    }



}
